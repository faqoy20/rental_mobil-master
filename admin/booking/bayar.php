<?php
/*
  | Source Code Aplikasi Rental Mobil PHP & MySQL
  | 
  | @package   : rental_mobil
  | @file	   : bayar.php 
  | @author    : faqoy@gmail.com
  | 
  | 
  | 
  | 
 */
require '../../koneksi/koneksi.php';
$title_web = 'Konfirmasi';
include '../header.php';
if (empty($_SESSION['USER'])) {
    session_start();
}
$kode_booking = $_GET['id'];
$hasil = $koneksi->query("SELECT * FROM booking WHERE kode_booking = '$kode_booking'")->fetch();

$id_booking = $hasil['id_booking'];
$hsl = $koneksi->query("SELECT * FROM pembayaran WHERE id_booking = '$id_booking'")->fetch();
$c = $koneksi->query("SELECT * FROM pembayaran WHERE id_booking = '$id_booking'")->rowCount();


$id = $hasil['id_mobil'];
$isi = $koneksi->query("SELECT * FROM mobil WHERE id_mobil = '$id'")->fetch();

?>
<main id="main" class="main">

    <div class="pagetitle">
        <h1>Booking</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?= $url ?>admin/index.php">Home</a></li>
                <li class="breadcrumb-item active"><a href="<?= $url ?>admin/booking/booking.php">Daftar Boking</a></li>
                <li class="breadcrumb-item active">Detail</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->

    <section class="section dashboard">
        <div class="row">

            <div class="container">
                <div class="row">
                    <div class="col-sm-4">
                        <div class="card">
                            <div class="card-header">
                                <h5> Detail Pembayaran</h5>
                            </div>
                            <div class="card-body">
                                <?php if ($c > 0) { ?>
                                    <table class="table">
                                        <tr>
                                            <td>No Rekening</td>
                                            <td> :</td>
                                            <td><?= $hsl['no_rekening']; ?></td>
                                        </tr>
                                        <tr>
                                            <td>Atas Nama </td>
                                            <td> :</td>
                                            <td><?= $hsl['nama_rekening']; ?></td>
                                        </tr>
                                        <tr>
                                            <td>Nominal </td>
                                            <td> :</td>
                                            <td>Rp. <?= number_format($hsl['nominal']); ?></td>
                                        </tr>
                                        <tr>
                                            <td>Tgl Transfer</td>
                                            <td> :</td>
                                            <td><?= $hsl['tanggal']; ?></td>
                                        </tr>
                                        <tr>
                                            <td>
                                                Bukti Pembayaran
                                            <td> :</td>
                                            <td><img src="../../assets/bukti/<?= $hsl['bukti'] ?>" width="100px"></td>
                                            </td>
                                        </tr>
                                    </table>
                                <?php } else { ?>
                                    <h4>Belum di bayar</h4>
                                <?php } ?>
                            </div>
                        </div>

                        <div class="card">
                            <div class="card-header">
                                <h5 class="card-title"><?php echo $isi['merk']; ?></h5>
                            </div>
                            <ul class="list-group list-group-flush">

                                <?php if ($isi['status'] == 'Tersedia') { ?>

                                    <li class="list-group-item bg-primary text-white">
                                        <i class="fa fa-check"></i> Available
                                    </li>

                                <?php } else { ?>

                                    <li class="list-group-item bg-danger text-white">
                                        <i class="fa fa-close"></i> Not Available
                                    </li>

                                <?php } ?>


                                <li class="list-group-item bg-info text-white"><i class="fa fa-check"></i> Free Snack & Drinks</li>
                                <li class="list-group-item bg-dark text-white">
                                    <i class="fa fa-money"></i> Rp. <?php echo number_format($isi['harga']); ?>/ day
                                </li>
                            </ul>
                            <div class="card-footer">
                                <a href="<?php echo $url; ?>admin/peminjaman/peminjaman.php?id=<?php echo $hasil['kode_booking']; ?>" class="btn btn-success btn-md">Ubah Status Peminjaman</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-8">
                        <div class="card">
                            <div class="card-header">
                                <h5> Detail booking</h5>
                            </div>
                            <div class="card-body">
                                <form method="post" action="proses.php?id=konfirmasi">
                                    <table class="table">
                                        <tr>
                                            <td>Kode Booking </td>
                                            <td> :</td>
                                            <td><?php echo $hasil['kode_booking']; ?></td>
                                        </tr>
                                        <tr>
                                            <td>KTP </td>
                                            <td> :</td>
                                            <td><?php echo $hasil['ktp']; ?></td>
                                        </tr>
                                        <tr>
                                            <td>Nama </td>
                                            <td> :</td>
                                            <td><?php echo $hasil['nama']; ?></td>
                                        </tr>
                                        <tr>
                                            <td>telepon </td>
                                            <td> :</td>
                                            <td><?php echo $hasil['no_tlp']; ?></td>
                                        </tr>
                                        <tr>
                                            <td>Tanggal Sewa </td>
                                            <td> :</td>
                                            <td><?php echo $hasil['tanggal']; ?></td>
                                        </tr>
                                        <tr>
                                            <td>Lama Sewa </td>
                                            <td> :</td>
                                            <td><?php echo $hasil['lama_sewa']; ?> hari</td>
                                        </tr>
                                        <tr>
                                            <td>Total Harga </td>
                                            <td> :</td>
                                            <td>Rp. <?php echo number_format($hasil['total_harga']); ?></td>
                                        </tr>
                                        <tr>
                                            <td>Status </td>
                                            <td> :</td>
                                            <td>
                                                <select class="form-control" name="status">
                                                    <option <?php if ($hasil['konfirmasi_pembayaran'] == 'Sedang di proses') {
                                                                echo 'selected';
                                                            } ?>>
                                                        Sedang di proses
                                                    </option>
                                                    <option <?php if ($hasil['konfirmasi_pembayaran'] == 'Pembayaran di terima') {
                                                                echo 'selected';
                                                            } ?>>
                                                        Pembayaran di terima
                                                    </option>
                                                </select>
                                            </td>
                                        </tr>
                                    </table>
                                    <input type="hidden" name="id_booking" value="<?php echo $hasil['id_booking']; ?>">
                                    <button type="submit" class="btn btn-primary float-right">
                                        Ubah Status
                                    </button>
                                </form>

                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </section>

</main>

<?php include '../footer.php'; ?>