<?php
use Slim\Http\Request;
use Slim\Http\Response;

$app->get("/berita/", function (Request $request, Response $response, $arg){
	$getRecord = $request->getParams();
	$status = isset($getRecord['status']) ? $getRecord['status'] : '';
	$page = isset($getRecord['page']) ? $getRecord['page'] : 1;
	$limit = isset($getRecord['limit']) ? $getRecord['limit'] : 12;
	$start = ($page - 1) * $limit;
	$sql = "SELECT id,deskripsi,cover,link,input_time FROM konten WHERE menu = 3 AND status LIKE '$status%' 
	ORDER BY id ASC LIMIT $start, $limit";
    $stmt = $this->db->prepare($sql);
	$stmt->execute();
    if($stmt->rowCount() > 0){
		$sqlCount = "SELECT id FROM konten WHERE menu = 3 AND status LIKE '$status%'";
		$stmtCount = $this->db->prepare($sqlCount);
		$stmtCount->execute();
		$result = $stmt->fetchAll();
		return $response->withJson(["success" => true, "total" => $stmtCount->rowCount(), "data" => $result, "message" => "Data Di Temukan"], 200);
	} else {
		return $response->withJson(["success" => false, "total" => 0, "data" => '', "message" => "Data Tidak Di Temukan"], 200);
	}
});
$app->post("/berita/", function (Request $request, Response $response, $args){
	$getRecord = $request->getParsedBody();
    $deskripsi = $getRecord['deskripsi'];
    $cover = $getRecord['cover'];
    $konten = $getRecord['konten'];
    $link = $getRecord['konten'];
	$user = $_SESSION['USER'];
	
	$cek = "SELECT * FROM konten WHERE periode = $periode AND status IN (2,3,4)";
	$stmtCek = $this->db->prepare($cek);
	$stmtCek->execute();
	
	if($stmtCek->rowCount() > 0){
		$resultCek = $stmtCek->fetch();
		$idRab = $resultCek['id'];
		if($resultCek['status'] == 4){
			return $response->withJson(["success" => false, "data" => '', "message" => "Perubahan RAB Sudah Final"], 200);
		} else {
			$sql = "UPDATE keuangan_rab SET status = $status, perubahan_oleh = $user WHERE periode = $periode";
			$stmt = $this->db->prepare($sql);
			if($stmt->execute()) {
				if(isset($getRecord['DETAIL_RECORD'])) {
					$detail = json_decode($getRecord['DETAIL_RECORD'],true);
					foreach($detail as $dtl) {
						$idAkun = $dtl['id'];
						$perubahan = $dtl['perubahan'];
						
						$sqlCekDtl = "SELECT * FROM keuangan_rab_detil WHERE rab = $idRab AND akun = $idAkun";
						$stmtCekDtl = $this->db->prepare($sqlCekDtl);
						$stmtCekDtl->execute();
						if($stmtCekDtl->rowCount() > 0) {
							$sql = "UPDATE keuangan_rab_detil SET perubahan = '$perubahan' WHERE rab = $idRab AND akun = $idAkun";
						} else {
							$sql = "INSERT INTO keuangan_rab_detil (rab,akun,anggaran,perubahan,status) VALUES ($idRab,$idAkun,0,$perubahan,1)";
						}
						
						$stmt = $this->db->prepare($sql);
						if($stmt->execute()) {
							$sukses = 1;
						} else {
							$sukses = 0;
						}
					}
				}
				return $response->withJson(["success" => true, "data" => '', "message" => "Data Berhasil Di Simpan"], 200);
			}
		}
	} else {
		return $response->withJson(["success" => false, "data" => '', "message" => "Rencana Anggaran Biaya Masih Kosong"], 200);
	}
});
function titleToPermalink($text='') {
	$text = trim($text);
	if (empty($text)) return '';
	  $text = preg_replace("/[^a-zA-Z0-9\-\s]+/", "", $text);
	  $text = strtolower(trim($text));
	  $text = str_replace(' ', '-', $text);
	  $text = $text_ori = preg_replace('/\-{2,}/', '-', $text);
	  return $text;
}  