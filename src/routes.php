<?php

use Slim\Http\Request;
use Slim\Http\Response;

$app->get('/', function (Request $request, Response $response, $args) {
    $response->getBody()->write("Server Telah Bekerja");
    return $response;
});

// $app->get('/Banner', function (Request $request, Response $response) {
//     $record = $request->getParsedBody();
//     $sql = "SELECT * FROM BANNER";
//     $stmt = $this->db->prepare($sql);
//     $stmt->execute();
//     if ($stmt->rowCount() > 0) {
//         $result = $stmt->fetchAll();
//         return $response->withJson(["success" => "true", "message" => 'Login Sukses', "data" => $result], 200);
//     } else {
//         return $response->withJson(["success" => "false", "message" => 'Data Tidak Di Temukan', "data" => ""], 201);
//     }
// });
$app->get("/Produk", function (Request $request, Response $response) {
    $record = $request->getParsedBody();
    $sql = "SELECT * FROM PRODUK";
    $stmt = $this->db->prepare($sql);
    $stmt->execute();
    if ($stmt->rowCount() > 0) {
        $result = $stmt->fetchAll();
        return $response->withJson(["success" => "true", "message" => 'Login Sukses', "data" => $result], 200);
    } else {
        return $response->withJson(["success" => "false", "message" => 'Data Tidak Di Temukan', "data" => ""], 201);
    }
});

$app->get("/Cart/{nomor}", function (Request $request, Response $response, $arg) {
    $getRecord = $request->getParams();
    $params = [
        ":nomor" => $arg["nomor"]
    ];
    $sql = "SELECT * FROM PESANAN WHERE ID_USER =:nomor";
    $stmt = $this->db->prepare($sql);
    $stmt->execute($params);
    if ($stmt->rowCount() > 0) {
        $result = $stmt->fetchAll();
        return $response->withJson(["success" => "true", "message" => 'Login Sukses', "data" => $result], 200);
    } else {
        return $response->withJson(["success" => "false", "message" => 'Data Tidak Di Temukan', "data" => ""], 201);
    }
});

// $app->get("/CekDiskon", function (Request $request, Response $response, $arg) {
//     $getRecord = $request->getParams();
//     $sql = "SELECT ID FROM PESANAN WHERE VERIFIKASI =3";
//     $stmt = $this->db->prepare($sql);
//     $stmt->execute($params);
//     if ($stmt->rowCount() > 0) {
//         $result = $stmt->fetchAll();
//         return $response->withJson(["success" => "true", "message" => 'Login Sukses', "data" => $result], 200);
//     } else {
//         return $response->withJson(["success" => "false", "message" => 'Data Tidak Di Temukan', "data" => ""], 201);
//     }
// });

$app->get("/Keranjang/{nomor}", function (Request $request, Response $response, $arg) {
    $getRecord = $request->getParams();
    $params = [
        ":nomor" => $arg["nomor"]
    ];
    $sql = "SELECT * FROM KERANJANG WHERE ID_USER =:nomor";
    $stmt = $this->db->prepare($sql);
    $stmt->execute($params);
    if ($stmt->rowCount() > 0) {
        $result = $stmt->fetchAll();
        return $response->withJson(["success" => "true", "message" => 'Login Sukses', "data" => $result], 200);
    } else {
        return $response->withJson(["success" => "false", "message" => 'Data Tidak Di Temukan', "data" => ""], 201);
    }
});

$app->post("/SearchProduk/{cari}", function (Request $request, Response $response, $arg) {
    $getRecord = $request->getParams();
    $params = [
        ":cari" => $arg["cari"]
    ];
    $cari = $params;
    $sql = "SELECT * FROM PRODUK WHERE MEREK LIKE '%" . $arg["cari"] . "%'";
    // $sql = "SELECT * FROM PRODUK WHERE MEREK =:cari";
    $stmt = $this->db->prepare($sql);
    $stmt->execute($params);
    if ($stmt->rowCount() > 0) {
        $result = $stmt->fetchAll();
        return $response->withJson(["success" => "true", "message" => 'Login Sukses', "data" => $result], 200);
    } else {
        return $response->withJson(["success" => "false", "message" => 'Data Tidak Di Temukan', "data" => ""], 201);
    }
});

$app->get("/CartList/{nomor}", function (Request $request, Response $response, $arg) {
    $getRecord = $request->getParams();
    $params = [
        ":nomor" => $arg["nomor"]
    ];
    $sql = "SELECT * FROM PRODUK k WHERE k.ID =:nomor";
    $stmt = $this->db->prepare($sql);
    $stmt->execute($params);
    if ($stmt->rowCount() > 0) {
        $result = $stmt->fetch();
        return $response->withJson(["success" => "true", "message" => 'Login Sukses', "data" => [$result]], 200);
    } else {
        return $response->withJson(["success" => false, "data" => '', "message" => "Data Tidak Di Temukan"], 201);
    }
});

$app->post("/SignIn", function (Request $request, Response $response) {
    $record = $request->getParsedBody();
    $sql = "SELECT * FROM USERS WHERE EMAIL =:EMAIL OR PASS =:PASS";
    $getsql = "SELECT * FROM USERS WHERE EMAIL = ?";
    $result = $this->db->prepare($getsql);
    $result->bindParam(1, $record["EMAIL"]);
    $result->execute();
    $user = $result->fetch();
    $stmt = $this->db->prepare($sql);
    $data = [
        ":EMAIL" => $record["EMAIL"],
        ":PASS" => $record["PASS"]
    ];
    $stmt->execute($data);
    if ($stmt->rowCount() > 0 && password_verify($record["PASS"], $user["PASS"])) {
        $result = $stmt->fetch();
        return $response->withJson(["success" => "true", "message" => 'Login Sukses', "data" => $result], 200);
    } else {
        return $response->withJson(["success" => "false", "message" => 'Username Dan Password Tidak Sesuai', "data" => ""], 201);
    }
});

$app->post("/CekAkun", function (Request $request, Response $response) {
    $record = $request->getParsedBody();
    $sql = "SELECT * FROM USERS WHERE EMAIL =:EMAIL";
    $stmt = $this->db->prepare($sql);
    $data = [
        ":EMAIL" => $record["EMAIL"]
    ];
    $stmt->execute($data);
    if ($stmt->rowCount() > 0) {
        $result = $stmt->fetch();
        return $response->withJson(["success" => "false", "message" => 'Terdapat email', "data" => $result], 200);
    } else {
        return $response->withJson(["success" => "true", "message" => 'Tidak terdapat email', "data" => ""], 201);
    }
});

$app->post("/Register", function (Request $request, Response $response) {
    $record = $request->getParsedBody();
    $sql = "INSERT INTO USERS (NAMA_DEPAN, NAMA_BELAKANG, EMAIL, PASS, PROVINSI, KOTA, TAG_KOTA, ALAMAT_LENGKAP, KODE_POS, NOMOR_TELEPON, LEVEL) 
			VALUE (:NAMA_DEPAN, :NAMA_BELAKANG, :EMAIL, :PASS, :PROVINSI, :KOTA, :TAG_KOTA, :ALAMAT_LENGKAP, :KODE_POS, :NOMOR_TELEPON, :LEVEL)";
    $stmt = $this->db->prepare($sql);
    $hash = password_hash(
        $record["PASS"],
        PASSWORD_DEFAULT
    );
    $data = [
        ":NAMA_DEPAN" => isset($record["NAMA_DEPAN"]) ? $record["NAMA_DEPAN"] : "",
        ":NAMA_BELAKANG" => isset($record["NAMA_BELAKANG"]) ? $record["NAMA_BELAKANG"] : "",
        ":EMAIL" => isset($record["EMAIL"]) ? $record["EMAIL"] : "",
        ":PASS" => isset($record["PASS"]) ? $hash : "",
        ":PROVINSI" => isset($record["PROVINSI"]) ? $record["PROVINSI"] : "",
        ":KOTA" => isset($record["KOTA"]) ? $record["KOTA"] : "",
        ":TAG_KOTA" => isset($record["TAG_KOTA"]) ? $record["TAG_KOTA"] : 0,
        ":ALAMAT_LENGKAP" => isset($record["ALAMAT_LENGKAP"]) ? $record["ALAMAT_LENGKAP"] : "",
        ":KODE_POS" => isset($record["KODE_POS"]) ? $record["KODE_POS"] : 0,
        ":NOMOR_TELEPON" => isset($record["NOMOR_TELEPON"]) ? $record["NOMOR_TELEPON"] : 0,
        ":LEVEL" => 1
    ];
    if ($stmt->execute($data)) {
        return $response->withJson(["success" => "true", "message" => 'Data Berhasil Di Simpan', "data" => $record], 200);
    } else {
        return $response->withJson(["success" => "false", "message" => 'Data Gagal Di Simpan', "data" => ""], 201);
    }
});


$app->post("/UpdateAlamat", function (Request $request, Response $response) {
    $record = $request->getParsedBody();
    $data = [
        ":ID" => isset($record["ID"]) ? $record["ID"] : null,
        ":PROVINSI" => isset($record["PROVINSI"]) ? $record["PROVINSI"] : "",
        ":KOTA" => isset($record["KOTA"]) ? $record["KOTA"] : "",
        ":TAG_KOTA" => isset($record["TAG_KOTA"]) ? $record["TAG_KOTA"] : 0,
        ":ALAMAT_LENGKAP" => isset($record["ALAMAT_LENGKAP"]) ? $record["ALAMAT_LENGKAP"] : "",
        ":KODE_POS" => isset($record["KODE_POS"]) ? $record["KODE_POS"] : 0
    ];
    $sql = "UPDATE USERS SET PROVINSI=:PROVINSI, KOTA=:KOTA, TAG_KOTA=:TAG_KOTA,
    ALAMAT_LENGKAP=:ALAMAT_LENGKAP, KODE_POS=:KODE_POS WHERE ID=:ID";
    $stmt = $this->db->prepare($sql);

    if ($stmt->execute($data)) {
        return $response->withJson(["success" => "true", "message" => "berhasil update"], 200);
    } else {
        return $response->withJson(["success" => "false", "message" => "Gagal"], 201);
    }
});

$app->post("/UpdateProfilNama", function (Request $request, Response $response) {
    $record = $request->getParsedBody();
    $data = [
        ":ID" => isset($record["ID"]) ? $record["ID"] : null,
        ":NAMA_BELAKANG" => isset($record["NAMA_BELAKANG"]) ? $record["NAMA_BELAKANG"] : ""
    ];
    $sql = "UPDATE USERS SET NAMA_BELAKANG=:NAMA_BELAKANG WHERE ID=:ID";
    $stmt = $this->db->prepare($sql);

    if ($stmt->execute($data)) {
        return $response->withJson(["success" => "true", "message" => "berhasil update"], 200);
    } else {
        return $response->withJson(["success" => "false", "message" => "Gagal"], 201);
    }
});

$app->post("/UpdateProfilNomor", function (Request $request, Response $response) {
    $record = $request->getParsedBody();
    $data = [
        ":ID" => isset($record["ID"]) ? $record["ID"] : null,
        ":NOMOR_TELEPON" => isset($record["NOMOR_TELEPON"]) ? $record["NOMOR_TELEPON"] : ""
    ];
    $sql = "UPDATE USERS SET NOMOR_TELEPON=:NOMOR_TELEPON WHERE ID=:ID";
    $stmt = $this->db->prepare($sql);

    if ($stmt->execute($data)) {
        return $response->withJson(["success" => "true", "message" => "berhasil update"], 200);
    } else {
        return $response->withJson(["success" => "false", "message" => "Gagal"], 201);
    }
});

$app->post("/TambahKeranjang", function (Request $request, Response $response) {
    $record = $request->getParsedBody();
    $sql = "INSERT INTO KERANJANG (ID_USER, ID_PRODUK, UKURAN_SEPATU) 
			VALUE (:ID_USER, :ID_PRODUK, :UKURAN_SEPATU)";
    $stmt = $this->db->prepare($sql);
    $data = [
        ":ID_USER" => isset($record["ID_USER"]) ? $record["ID_USER"] : "",
        ":ID_PRODUK" => isset($record["ID_PRODUK"]) ? $record["ID_PRODUK"] : "",
        ":UKURAN_SEPATU" => isset($record["UKURAN_SEPATU"]) ? $record["UKURAN_SEPATU"] : ""
    ];
    if ($stmt->execute($data)) {
        return $response->withJson(["success" => "true", "message" => 'Data Berhasil Di Simpan', "data" => $record], 200);
    } else {
        return $response->withJson(["success" => "false", "message" => 'Data Gagal Di Simpan', "data" => ""], 201);
    }
});

$app->post('/Pesan', function (Request $request, Response $response) {
    $record = $request->getParsedBody();
    $sql = "INSERT INTO PESANAN (ID_USER, ID_PRODUK, UKURAN_SEPATU, JUMLAH_PESANAN, ONGKIR, METODE_PEMBAYARAN, ESTIMASI, TOTAL_PESANAN,TANGGAL_PEMESANAN, STATUS, VERIFIKASI) 
			            VALUE (:ID_USER, :ID_PRODUK, :UKURAN_SEPATU, :JUMLAH_PESANAN, :ONGKIR, :METODE_PEMBAYARAN, :ESTIMASI, :TOTAL_PESANAN, :TANGGAL_PEMESANAN, :STATUS, :VERIFIKASI)";
    $stmt = $this->db->prepare($sql);
    $data = [
        ":ID_USER" => isset($record["ID_USER"]) ? $record["ID_USER"] : "0",
        ":ID_PRODUK" => isset($record["ID_PRODUK"]) ? $record["ID_PRODUK"] : "",
        ":UKURAN_SEPATU" => isset($record["UKURAN_SEPATU"]) ? $record["UKURAN_SEPATU"] : "",
        ":JUMLAH_PESANAN" => isset($record["JUMLAH_PESANAN"]) ? $record["JUMLAH_PESANAN"] : "",
        ":ONGKIR" => isset($record["ONGKIR"]) ? $record["ONGKIR"] : "",
        ":METODE_PEMBAYARAN" => isset($record["METODE_PEMBAYARAN"]) ? $record["METODE_PEMBAYARAN"] : "",
        ":ESTIMASI" => isset($record["ESTIMASI"]) ? $record["ESTIMASI"] : "",
        ":TOTAL_PESANAN" => isset($record["TOTAL_PESANAN"]) ? $record["TOTAL_PESANAN"] : "",
        ":TANGGAL_PEMESANAN" => date('Y-m-d'),
        ":STATUS" => 1,
        ":VERIFIKASI" => 1
    ];
    if ($stmt->execute($data)) {
        return $response->withJson(["success" => "true", "message" => 'Data Berhasil Di Simpan', "data" => $record], 200);
    } else {
        return $response->withJson(["success" => "false", "message" => 'Data Gagal Di Simpan', "data" => ""], 201);
    }
});

$app->post("/DeleteCart", function (Request $request, Response $response) {
    $record = $request->getParsedBody();
    $data = [
        ":ID" => isset($record["ID"]) ? $record["ID"] : null
    ];
    $sql = "DELETE FROM KERANJANG WHERE ID=:ID";
    $stmt = $this->db->prepare($sql);

    if ($stmt->execute($data)) {
        return $response->withJson(["success" => "true", "message" => "berhasil hapus"], 200);
    } else {
        return $response->withJson(["success" => "false", "message" => "Gagal"], 201);
    }
});

$app->post("/DeletePesanan", function (Request $request, Response $response) {
    $record = $request->getParsedBody();
    $data = [
        ":ID" => isset($record["ID"]) ? $record["ID"] : null
    ];
    $sql = "DELETE FROM PESANAN WHERE ID=:ID";
    $stmt = $this->db->prepare($sql);

    if ($stmt->execute($data)) {
        return $response->withJson(["success" => "true", "message" => "Pesanan di hapus"], 200);
    } else {
        return $response->withJson(["success" => "false", "message" => "Gagal"], 201);
    }
});




function jin_gfile($txt)
{
    $txt = preg_replace("/[^a-zA-Z0-9s.]", "_", trim($txt));
    return $txt;
}

// $app->get('/[{name}]', function (Request $request, Response $response, array $args) {
//     $this->logger->info("Slim-Skeleton '/' route");
//     return $this->renderer->render($response, 'index.phtml', $args);
// });
