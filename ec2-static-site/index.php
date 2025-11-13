<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>My EC2 Dynamic Site</title>
</head>
<body>
  <h1>Hello from EC2!</h1>

  <h2>Dynamic Server Time</h2>
  <p>The current server time is:
     <strong><?php echo date('Y-m-d H:i:s'); ?></strong>
  </p>

  <h2>Why This Is Different From S3</h2>
  <ul>
    <li>The time above changes every refresh.</li>
    <li>It is created by PHP running on the server.</li>
    <li>S3 cannot run server code, so S3 cannot do this.</li>
  </ul>
</body>
</html>
