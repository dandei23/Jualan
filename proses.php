<?php
include "db/koneksi.php";
$data=mysql_query("select * from user");
$op=isset($_GET['op'])?$_GET['op']:null;
if($op=='kode'){
	echo "<option>Kode Barang</option>";
	while($r=mysql_fetch_array($data)){
		echo "<option value='$r[kode]'>$r[kode]</option>";
	}
}elseif($op=='barang'){
	echo '<thead>
	<tr>
	<td colspan="5?><a href="?page=barang&act=tambah">Tambah Barang</a></td>
	</tr>
	<tr>
	<td>Kode</td>
	<td>Nama</td>
	<td>Username</td>
	<td>Password</td>
	</tr>
	</thead>';
	while($b=mysql_fetch_array($data)){
		echo"<tr>
		<td>$b[kode]</td>
		<td>$b[nama]</td>
		<td>$b[usrname]</td>
		<td>$b[password]</td>
		</tr>";
	}
}elseif($op=='ambildata'){
	$kode=$_GET['kode'];
	$dt=mysql_query("SELECT * FROM user WHERE kode='$kode");
	$d=mysql_fetch_array($dt);
	echo $d['nama']."|".$d['username']."|".$d['password']."|";
	}elseif($op=='update'){
		$kode=$_GET['kode'];
		$nama=htmlspecialchars($_GET['nama']);
		$beli=htmlspecialchars($_GET['beli']);
		$jual=htmlspecialchars($_GET['jual']);
		$stok=htmlspecialchars($_GET['stok']);
		$update=mysql_query("UPDATE tblbarang SET nama='$nama',
			hrg_beli='$beli',
			hrg_jual='$jual',
			stok='$stok'
			where kode='$kode");
		if($update){
			echo "Sukses";
		}else{
			echo "ERROR. . .";
		}
	}elseif($op=='delete'){
		$kode=$_GET['kode'];
		$del=mysql_query("DELETE FROM tblbarang WHERE kode='$kode");
		if($del){
			echo "sukses";
		}else{
			echo "ERROR";
		}
	}elseif($op=='simpan'){
		$kode=$_GET['kode'];
		$nama=htmlspecialchars($_GET['nama']);
		$jual=htmlspecialchars($_GET['jual']);
		$beli=htmlspecialchars($_GET['beli']);
		$stok=htmlspecialchars($_GET['stok']);
		$tambah=mysql_query("INSERT INTO tblbarang (kode,nama,hrg_beli,hrg_jual,stok) VALUES ('$kode','$nama','$beli','$jual','$stok')");
		if($tambah){
			echo "sukses";
		}else{
			echo "error";
		}
	}
?>
