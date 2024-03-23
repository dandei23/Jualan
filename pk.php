<?
include 'db/koneksi.php';
$op=isset($_GET['op'])?$_GET['op']:null;
if($op=='ambilbarang'){
	$data = mysql_query("SELECT * FROM tblbarang");
	echo "<option>KOde Barang</option>";
	while ($r=mysql_fetch_array($data)) {
		echo "<option value='$r[kode]'>$r[kode]</option>";
	}
}elseif ($op=='ambildata') {
	$kode=$_GET['kode'];
	$dt=mysql_query("SELECT * FROM tblbarang WHERE kode='$kode'");
	$d=mysql_fetch_array($dt);
	echo $d['name'].|.$d['harga_jual'].|.$d['stok'];
}elseif ($op=='ambilbarang') {
	$brg=mysql_query("SELECT * FROM tblsementara");
	echo "<thead>
		<tr>
			<td>Kode Barang</td>
			<td>Nama</td>
			<td>Harga</td>
			<td>Jumlah Beli</td>
			<td>Subtotal</td>
			<td>Tools</td>
		</tr>
	</thead>";
	$total=mysql_fetch_array(mysql_query("SELECT sum(subtotal) AS total FROM tblsementara"));
	while($r=mysql_fetch_array($brg)){
		echo "<tr>
			<td>$r[kode]</td>
			<td>$r[nama]</td>
			<td>$r[harga]</td>
			<td><input type='text' name='jum' value='$r[jumlah]' class='span2'></td>
			<td>$r[subtotal]</td>
			<td><a href='pk.php?op=hapus&kode=$r[kode]'' id='hapus'>Hapus</a></td>
		</tr>";
		echo "<tr>
			<td colspan='3'>Total</td>
			<td colspan='4'>$total[total]</td>
		</tr>";
	}elseif($op=='tambah'){
		$kode=$_GET['kode'];
		$nama=$_GET['nama'];
		$harga=$_GET['harga'];
		$jumlah=$_GET['jumlah'];
		$subtotal=$harga*$jumlah;
		$tambah=mysql_query("INSERT INTO tblsementara (kode,nama,harga,jumlah,subtotal) VALUES ('$kode','$nama','$harga','$jumlah','$subtotal')");
		if($tambah){
			echo "sukses";
		}else{
			echo "ERROR";
		}
	}elseif($op=='hapus'){
		$kode=$_GET['kode'];
		$del=mysql_query("delete from tblsementara where kode='$kode'");
		if($del){
			echo "<script>window.location='index.php?page=penjualan&act=tambah';</script>";
		}else{
			echo "<script>alert('Hapus Data Berhasil');
			window.location='index.php?page=penjualan&act=tambah';</script>";
		}
	}elseif($op=='proses'){
		$nota=$_GET['nota'];
		$tanggal=$_GET['tanggal'];
		$to=mysql_fetch_array(mysql_query("SELECT sum(subtotal) AS total FROM tblsementara"));
		$tot=$to['total'];
		$simpan=mysql_query("INSERT INTO penjualan(nonota,tanggal,total) VALUES ('$nota','$tanggal','$tot')");
		if($simpan){
			$query=mysql_query("SELECT * FROM tblsementara");
			while($r=mysql_fetch_row($query)){
				mysql_query("INSERT INTO detailpenjualan(nonota,kode,harga,jumlah,subtotal) VALUES('$nota','$r[0]','$r[2]','$r[3]','$r[4]')");
				mysql_query("UPDATE tblbarang SET stok=stok-'$r[3]' WHERE kode='$r[0]'");
			}
			//hapus seluruh isi tabel sementara
			mysql_query("truncate table tblsementara");
			echo "sukses";
		}else{
			echo "ERROR";
		}
	}
?>