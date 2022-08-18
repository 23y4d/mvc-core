</head>
<body>
  <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container-fluid">
      <a class="navbar-brand" href="/">MVC</a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target=".navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse ">
        <ul class="navbar-nav ">
          <li class="nav-item">
            <a class="nav-link " href="/home/x">Home</a>
          </li>
        </ul>
      </div>
    </div>
  </nav>
  <div class="container mt-5">
<?php
foreach (app()->session->getFlash() as $flash) {
  echo '<div class="alert alert-'.$flash['type'].' mt-5">';
  echo $flash['value'];
  echo '</div>';
}
?>
{{text}}
</div></body>
