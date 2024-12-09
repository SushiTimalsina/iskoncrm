<!doctype html>
<html>
<head>
<meta charset="UTF-8">
<title>Iskcon</title>
</head>

<body>
    <img src="data:image/png;base64, <?php echo base64_encode(file_get_contents($img)); ?>" style="max-width:100%;" />
    <div style="width: 100%; position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); font-size:46px; min-height:500px;">

      <h2 style="text-align:center;">{{$name}}</h2>

      <div style="margin-top:40px;">
        <div style="width:32.33%; display:inline-block; vertical-align:middle;"><div style="padding:15px; text-align:center;"><img src="{{$signature}}" style="max-width:50%;" /><br />Patri Das</div></div>
        <div style="width:32.33%; display:inline-block; vertical-align:middle;"><div style="padding:15px; text-align:center;"><img src="{{$signature}}" style="max-width:50%;" /><br />Patri Das</div></div>
        <div style="width:32.33%; display:inline-block; vertical-align:middle;"><div style="padding:15px; text-align:center;"><img src="{{$signature}}" style="max-width:50%;" /><br />Patri Das</div></div>
      </div>
    </div>


	</body>
</html>
