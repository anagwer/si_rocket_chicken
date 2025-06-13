<?php
	if(!$bool){
?>
<div class="modal fade" id="delete_pesanan<?php echo $id_pesanan?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
		<div class="modal-header">
				<h5 class="modal-title">Hapus</h5>
				<button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
			</div>
																
			<div class="modal-body">
				Apa Kamu yakin akan menghapus pesanan?
			</div>
									
			<div class="modal-footer">
				<form method = "post" enctype = "multipart/form-data">	
				<input type="hidden" name="id_pesanan" value="<?php echo $row['id_pesanan'] ?>">
				<button name = "delete" type="submit" class="btn btn-danger">Yes</button>
				</form>
				<button class="btn btn-secondary" data-dismiss="modal" aria-hidden="true"><i class="icon-remove icon-large"></i>&nbsp;Close</button>
			</div>
		</div>
			
<!-- /.modal-content -->

	</div>
		
<!-- /.modal-dialog -->
	
</div>
<?php
	require_once 'dbcon.php';
	if(ISSET($_POST['delete'])){
		$id_pesanan=$_POST['id_pesanan'];
		$conn->query("delete from pesanan where id_pesanan='$id_pesanan'") or die(mysql_error());
		echo "<script> window.location='pesanan.php' </script>";
	}
}
?>