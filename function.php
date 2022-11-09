<?php 
// koneksi ke database
$conn = mysqli_connect("localhost","root","","phpdasar");
// menampilkan data dari tabel
function query($query){
    global $conn;
    $result = mysqli_query($conn,$query);
    $rows = [];
    while($row = mysqli_fetch_assoc($result)){
        $rows[] = $row;
    }
    return $rows;
}

function tambah($data){
    global $conn;
    // ambil data dari tiap data elemen dalam form
$nama = htmlspecialchars($data["nama"]);
$nrp = htmlspecialchars($data["nrp"]);
$email = htmlspecialchars($data["email"]);
$jurusan = htmlspecialchars($data["jurusan"]);

// upload gambar
$gambar = upload();
if(!$gambar){
    return false;
}

// query insert data
$query = "INSERT INTO mahasiswa VALUES ('','$nama','$nrp','$email','$jurusan','$gambar')";
mysqli_query($conn, $query);

return mysqli_affected_rows($conn);
}
// upload
function upload(){
    
    $namaFile = $_FILES['gambar']['name'];
    $ukuranFile =$_FILES['gambar']['size'];
    $error = $_FILES['gambar']['error'];
    $tmpName = $_FILES['gambar']['tmp_name'];

    // cek apakah tidak ada gambar yang diupload
    if($error === 4){
        echo "<script>
        alert('pilih gambar lebih dahulu!');
        </script>";
        return false;
    }
    //cek apakah yang diupload adalah gambar
    $ekstensigambarvalid = ['jpg','jpeg','png',];
    $ekstensigambar = explode('.',$namaFile);
    $ekstensigambar = strtolower(end($ekstensigambar));
    if(!in_array($ekstensigambar,$ekstensigambarvalid)){
        echo "<script>
        alert('yang anda upload bukan gambar!');
        </script>";
        return false;
    }
    // cek jika ukurannya terlalu besar
    if($ukuranFile > 10000000){
        echo "<script>
        alert('ukuran gambar terlalu besar!');
        </script>";
        return false;
    }
    // lolos pengecekan gambar siap diupload
    // generate nama baru
    $namaFileBaru = uniqid();
    $namaFileBaru .='.';
    $namaFileBaru .= $ekstensigambar;

    move_uploaded_file($tmpName,'img/'.$namaFileBaru);
    return $namaFileBaru;


}

// menghapus data
function hapus($id){
    global $conn;
    mysqli_query($conn, "DELETE FROM mahasiswa WHERE id = $id");

    return mysqli_affected_rows($conn);
}

// mengubah data
function ubah($data){
    global $conn;
    // ambil data dari tiap data elemen dalam form
$id =$data["id"];
$nama = htmlspecialchars($data["nama"]);
$nrp = htmlspecialchars($data["nrp"]);
$email = htmlspecialchars($data["email"]);
$jurusan = htmlspecialchars($data["jurusan"]);
$gambarLama = htmlspecialchars($data["gambarLama"]);
// cek apakah user pilih gambar baru atau tidak
if($_FILES['gambar']['error']===4){
    $gambar = $gambarLama;
}else{
    $gambar = upload();

}

// query ubah data
$query = "UPDATE mahasiswa SET 
nama = '$nama',
nrp = '$nrp',
email = '$email',
jurusan = '$jurusan',
gambar = '$gambar'
WHERE id =$id
";

mysqli_query($conn, $query);

return mysqli_affected_rows($conn);
}

function cari($keyword){
    $query = "SELECT * FROM mahasiswa WHERE
    nama LIKE '%$keyword%' OR
    nrp LIKE '%$keyword%' OR
    email LIKE '%$keyword%' OR
    jurusan LIKE '%$keyword%'
    ";
    return query($query);
}
// Registrasi
function registrasi($data){
    global $conn;

    $username = strtolower(stripcslashes ($data["username"]));
    $password = mysqli_real_escape_string($conn,$data["password"]);
    $password2 = mysqli_real_escape_string($conn, $data["password2"]);
    // username udah ada atau belum
    $result = mysqli_query($conn, "SELECT username FROM users WHERE username = '$username'");
    if(mysqli_fetch_assoc($result)){
        echo "<script>
        alert('username sudah terdaftar!');
        </script>";
        return false;
    }
// check konfirmasi password
if( $password !== $password2 ){
    echo "<script>
    alert('konfirmasi password tidak sesuai!');
    </script>";
    return false;
}
// enkripsi password
$password = password_hash($password,PASSWORD_DEFAULT);

// tambahkan user baru ke database
mysqli_query($conn,"INSERT INTO users VALUES('','$username','$password')");

return mysqli_affected_rows($conn);

}
?>
