<?php 
include('../../asset/header.php');
include('../../koneksi/koneksi.php');
@session_start();
if($_SESSION['username'] == ''){
    @header('location:../../index.php');
}
?>

<?php 
include('../../koneksi/koneksi.php');
if(isset($_POST['ngadu'])){
    $nik = $_POST['nik'];
    $tgl = $_POST['tgl'];
    $pengaduan = $_POST['pengaduan'];
    $foto = $_POST['foto'];

    $q = mysqli_query($con, "INSERT INTO pengaduan (nik, tgl_pengaduan, isi_laporan, foto) VALUES ('$nik', '$tgl', '$pengaduan', '$foto')");
}

if(isset($_POST['tanggap'])){
    $id_pengaduan = $_POST['id_pengaduan'];
    $tgl = $_POST['tgl'];
    $tanggapan = $_POST['tanggapan'];
    $petugas = $_POST['petugas'];
    $status = $_POST['status'];

    $s = mysqli_query($con, "UPDATE pengaduan SET status = '$status' WHERE id_pengaduan = '$id_pengaduan'");
    $q = mysqli_query($con, "INSERT INTO tanggapan (id_pengaduan, tgl_tanggapan, tanggapan, id_petugas) VALUES ('$id_pengaduan', '$tgl', '$tanggapan', '$petugas')");
}
?>

<body>
<nav class="navbar navbar-expand-lg navbar-light bg-primary">
  <div class="container-fluid">
    <a class="navbar-brand" href="#">Navbar</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <li class="nav-item">
          <a class="nav-link active" aria-current="page" href="../modul-masyarakat/">Masyarakat</a>
        </li>
        <li class="nav-item">
          <a class="nav-link active" aria-current="page" href="../modul-pengaduan/">Pengaduan</a>
        </li>
        <?php 
            if($_SESSION['level'] == 'masyarakat'){
                ?> 
                    <li class="nav-item">
                        <a class="nav-link disabled">Petugas</a>
                    </li>
                <?php
            }else{
                ?> 
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="../modul-petugas">Petugas</a>
                    </li>
                <?php
            }
        ?>
        <li class="nav-item">
          <a class="nav-link active" aria-current="page" href="../modul-tanggapan">Tanggapan</a>
        </li>
        
        <li class="nav-item">
          <a class="nav-link active" aria-current="page" href="../modul-auth/logout.php">Logout</a>
        </li>
      </ul>
    </div>
  </div>
</nav>
<table class="table table-dark table-striped">
  <thead>
    <tr>
      <th scope="col">ID Pengaduan</th>
      <th scope="col">Tgl Pengaduan</th>
      <th scope="col">NIK</th>
      <th scope="col">Pengaduan</th>
      <th scope="col">Foto</th>
      <th scope="col">Status</th>
    </tr>
  </thead>
  <tbody>
        <?php
            include('../../koneksi/koneksi.php');
            $q = mysqli_query($con, "SELECT * FROM pengaduan");
            while($m = mysqli_fetch_object($q)){
                ?> 
                    <tr>
                        <td><?= $m -> id_pengaduan ?></td>
                        <td><?= $m -> tgl_pengaduan ?></td>
                        <td><?= $m -> nik ?></td>
                        <td><?= $m -> isi_laporan ?></td>
                        <td><?= $m -> foto ?></td>
                        <td><?= $m -> status ?></td>
                    </tr>
                <?php
            }
        ?>
  </tbody>
</table>

<?php 
if($_SESSION['level']=='masyarakat'){
    ?> 
        <div class="card">
            <div class="card-header">
                <h4>.:Tambah Pengaduan:.</h4>
            </div>
            <div class="card-body">
                <form action="" method="post">
                <div class="mb-3">
                    <label for="nik" class="form-label">NIK (Terisi Otomatis)</label>
                    <input type="text" readonly class="form-control" id="nik" name="nik" value="<?= $_SESSION['nik'] ?>">
                </div>
                <div class="mb-3">
                    <label for="tgl">Tanggal Pengaduan</label>
                    <input type="date" class="form-control" id="tgl" name="tgl">
                </div>
                <div class="mb-3">
                    <label for="pengaduan">Pengaduan</label>
                    <textarea name="pengaduan" id="pengaduan" class="form-control" rows="3" placeholder="Isi Laporan..."></textarea>
                </div>
                <div class="mb-3">
                    <label for="foto">Gambar</label>
                    <input name="foto" type="file" class="form-control">
                </div>
                <div class="mb-3">
                    <button class="btn btn-success" name="ngadu">Kirim Pengaduan</button>
                </div>
                </form>
            </div>
            <div class="body-footer">
                <h4>.::.</h4>
            </div>
        </div>
    <?php
}else{
    ?> 
        <div class="card">
            <div class="card-header bg-primary">
                <h4>.:Tambah Tanggapan:.</h4>
            </div>
            <div class="card-body">
                <form action="" method="post">
                <div class="mb-3">
                <label for="id_pengaduan">ID Pengaduan</label>
                <select name="id_pengaduan" class="form-select" aria-label="Default select example">
                    <?php 
                        $q = mysqli_query($con, "SELECT * FROM pengaduan");
                        while($o = mysqli_fetch_object($q)){
                            ?> 
                                <option value="<?= $o -> id_pengaduan ?>"><?= $o -> id_pengaduan ?></option>
                            <?php
                        }
                    ?>
                </select>
                </div>
                <div class="mb-3">
                    <label for="tgl">Tanggal tanggapan</label>
                    <input type="date" class="form-control" id="tgl" name="tgl">
                </div>
                <div class="mb-3">
                    <label for="tanggapan">TAnggapan</label>
                    <textarea name="tanggapan" id="tanggapan" class="form-control" rows="3" placeholder="Isi Tanggapan..."></textarea>
                </div>
                <div class="mb-3">
                    <label for="petugas">ID Petugas</label>
                    <input name="petugas" readonly type="text" class="form-control" value="<?= $_SESSION['id_petugas'] ?>">
                </div>
                <div class="mb-3">
                    <select name="status" class="form-select">
                        <option value="proses">Proses</option>
                        <option value="selesai">Selesai</option>
                    </select>
                </div>
                <div class="mb-3">
                    <button class="btn btn-success" name="tanggap">Kirim Tnggapan</button>
                </div>
                </form>
            </div>
            <div class="body-footer">
                <h4>.::.</h4>
            </div>
        </div>
    <?php
}
?>
</body>