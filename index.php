<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ajax perpustakaan</title>
    <link rel="stylesheet" href="css/bootstrap.min.css">
</head>
<body>
    <div class="container">
        <div class="row mt-3">
            <div class="col-sm-12">
                <!--awal card-->
                <div class="card">
                    <div class="card-header text-bg-success">
                        data buku
                    </div>
                    <div class="card-body">
                        <form>
                            <div class="row">
                                <label for="judul" class="col-sm-4 col-form-label">Judul Buku</label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control" id="judul">
                                </div>
                            </div>
                            <div class="row mt-3">
                                <div class="col-sm-3 offset-9">
                                    <button class="btn btn-primary float-end" id="simpan">Simpan</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <!--akhir card-->
            </div>
        </div>
        <div class="row mt-3">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Judul</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody id="tempatData">
                    
                </tbody>
            </table>
        </div>
    </div>
    <script src="js/jquery.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script>
        $(document).ready(function(){
            tampil_data();
            
            //saat elemen dengan id "simpan" di click jalankan fungsi 
            $('#simpan').on('click', function(e){
                e.preventDefault(); //diberi parameter e, preventDefault intinya tidak menjalankan fungsi bawaan
                var judul = $('#judul').val();
                
                $.ajax({
                    type : "POST",
                    url : "simpandata.php",
                    data : {judul:judul},
                    success: function(hasil){
                        console.log(hasil);
                        tampil_data();
                        $('#judul').val("");
                    }
                })
            })

            //membuat fungsi untuk menampilkan data
            function tampil_data(){
                $.ajax({
                    url : "ambilsemua.php",
                    type : "GET",
                    dataType : "json",
                    success : function(hasil){
                        console.log(hasil);
                        var html = "";
                        var i;
                        var no = 1;

                        if (hasil.total==0){
                            html += '<tr>' + 
                                        '<td colspan="3" class="text-center">Data pada tabel masih kosong</td>'+
                            '</tr>'
                        } else {
                            for(i=0; i < hasil.total;i++){
                                html += '<tr>'+
                                            '<td>'+ no++ +'</td>'+
                                            '<td>'+ hasil.data[i].judul +'</td>'+
                                            '<td>'+ 
                                                '<button class="btn btn-warning" id="edit" data-id="'+ hasil.data[i].id +'">Edit</button>'+' '+
                                                '<button class="btn btn-danger" id="hapus" data-id="'+ hasil.data[i].id +'">Hapus</button>'+
                                            '</td>'+
                                        '</tr>'
                            }
                            $('#tempatData').html(html);
                        }
                    }
                })
            }

            //untuk hapus
            $('#tempatData').on('click', '#hapus', function(){
                var id = $(this).data('id');
                $.ajax({
                    url : 'hapusdata.php',
                    type : 'POST',
                    data : {id:id},
                    success : function(hasil){
                        tampil_data();
                        location.reload();
                    }
                })
            })

            //tombol edit
            $('#tempatData').on('click', '#edit', function(){
                var id = $(this).data('id');
                $.ajax({
                    url : 'ambilsatuData.php',
                    type : 'GET',
                    data : {id:id},
                    success : function(hasil){
                        $('#judul').val(hasil.judul);
                    }
                })
            })

        })
    </script>
</body>
</html>
