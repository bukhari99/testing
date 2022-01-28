<!doctype html>
<html>
    <head>
        <title></title>
        
        <link rel="stylesheet" href="./multipleselect/select2.min.css"/>
    </head>
    <body>
        <div style="width: 100%; padding: 15px">
            <div class="form-group">
                <select id="tujuan" name="tujuan[]" class="form-control" multiple="multiple" size="30%">
                   <?php
				   		if($_GET['pilihan'] and $_GET['pilihan']=='input-sk' and $_GET['id']){
							echo "<option value=\"$r3[6]\" selected=\"selected\">$r3[6]</option>";
						}
						elseif($_GET['pilihan'] and $_GET['pilihan']=='input-user'  and $_GET['id']){
							echo "<option value=\"$r3[0]\" selected=\"selected\">$r3[0]</option>";
						}
		if($_GET['pilihan'] and $_GET['pilihan']=='input-sk'){
			echo "
				  <option value=\"Semua\">Semua</option>
				  <option value=\"Bidang\">Bidang</option>
				  <option value=\"UPT KHUSUS\">UPT KHUSUS</option>
				  <option value=\"UPT SAMSAT\">UPT SAMSAT</option>";
		}				
  		$sql2 = mysql_query("select * from myapp_maintable_tujuan_sk order by nama_tujuan asc");
		while($r2 = mysql_fetch_array($sql2)){
			echo "<option value=\"$r2[nama_tujuan]\">$r2[nama_tujuan]</option>";
		}
  ?>
                </select>
            </div>
        </div>
        <script src="./multipleselect/jquery-1.12.3.min.js"></script>
        <script src="./multipleselect/select2.min.js"></script>
        <script>
            $(document).ready(function () {
                $("#tujuan").select2({
                    placeholder: "Silakan Pilih Tujuan Surat Keluar"
                });
            });
        </script>
    </body>
</html>