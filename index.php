<!DOCTYPE html>
<html>
	<head>
	 	<meta charset="utf-8">
	 	<link rel="stylesheet" type="text/css" href="css/style.css" />
	    <meta http-equiv="X-UA-Compatible" content="IE=edge">
	    <meta name="viewport" content="width=device-width, initial-scale=1">
		<title> Сократитель ссылок </title>
		<script type="text/javascript" src="http://code.jquery.com/jquery-2.1.4.min.js"> </script>
		<script src="js/jquery-ui-1.10.3.custom.min.js"></script>
		<link href="css/bootstrap.min.css" rel="stylesheet">
		<script src="js/bootstrap.min.js"></script> 
		<script> 
			  function shortURL() {
			  	var formData = new FormData($('#add')[0]);

				$.ajax({
					url: 'shorter.php',
					type : 'POST',
					processData:false,
					contentType:false,
					data :formData,
					success: function (data) {
						if (data == "Ошибка! Возможно, некорректный URL?" || data == "Ошибка создания ссылки"){
							alert(data);
						} else {
							array = jQuery.parseJSON(data);	
							document.getElementById("textCopy").value = array[1];
							$(document).ready(function() {
						    $("#myModalBox").modal('show');
						    $('.modal-title').html(array[0]);
						  });

							$("form")[0].reset();
							getUrls();
						}
					}
				});
			}

			function getUrls() {
				document.getElementById("tableBody").innerHTML = "";
				$.get('getUrls.php' ,function (data) {
						array = jQuery.parseJSON(data);
						for (var i = 0; i < array.length; i++) {		
							document.getElementById("tableBody").innerHTML += "<tr><td width='200'><a href='"+array[i][0]+"' target='_blank'>" + array[i][0].split('/').slice(0, 3).join('/')+'/' + "</a></td><td><a href='"+array[i][0]+"' target='_blank'>" + array[i][1] + "</a></td><td>" + array[i][2] + "</td></tr>";
						}
					});
			}

			$(document).ready(function() {
				getUrls();

				var button = document.getElementById("copyBtn");
			
		button.addEventListener("click", function(event) {

			var CopiedTxt = $("#textCopy");
			event.preventDefault();
			CopiedTxt.select();
			document.execCommand("copy");
		});

			});
			
		</script>
	</head>
	<body>
		<div class="container-fluid main-container">
			<h4 align="center"> Введите Ваш URL </h4><br>
			<form method="" id="add">
				<div class="col-md-9">
					<input type="url" required class="form-control"   placeholder="Введите URL" autocomplete="off" name="url" />
				</div>
				<div class="col-md-3">
					<input class="btn btn-default btn-add" type="button" value="Сократить URL" name="add" onclick="shortURL()">
				</div>
			</form>
			<div id="myModalBox" class="modal fade">
				<div class="modal-dialog">
					<div class="modal-content">
					  
					  <div class="modal-header">
					    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
					    <h4 class="modal-title"></h4>
					  </div>
					  <div class="modal-body">
					  	<input type="url" id="textCopy" readonly style="border: none;">
					  </div>
					  <div class="modal-footer">
					    <input type="button" class="btn btn-primary" id="copyBtn" value="Скопировать"> 
					  </div>
					</div>
				</div>
			</div>
	 	</div>
	 	<div class="container-fluid main-container" id="container2">
			<table class="table table-condensed">
				<thead>
				    <tr>
				        <th>Ссылка</th>
				        <th>Сокращённая ссылка</th>
				        <th>Создана</th>
				    </tr>
				</thead>
				<tbody id="tableBody">
				</tbody>
			</table>	
		</div>
	</body>
</html>