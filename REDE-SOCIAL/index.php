<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>JustU</title>
  <link rel="stylesheet" href="./assets/css/index.css" />

  <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet" />
  <link rel="icon" href="./assets/images/JustU logo.png" type="image/x-com">
</head>

<body>
  <!--LEFT SIDEBAR-->
  <section class="left-sidebar">
    <div class="container" id="preferences-container">
      <div class="card"> <img src="./assets/images-preferences/anime.jpg" alt="">
        <h3>ANIME</h3>
      </div>
    </div>
  </section>

  <!--MIDDLE PAGE-->

  <section class="home">
    <p>Home Content Here</p>
    <a href="./public/signin.php">LOGIN</a>
    <h1 id="logado"></h1>
    <a href="./public/logout.php">DESLOGAR</a>
    <br>
    <a href="./public/test.php">Teste</a>
    <br>
    <button class="theme-btn">
      Trocar Tema
      <div class="theme-ball"></div>
    </button>
  </section>

  <!--RIGHT SIDEBAR-->

  <section class="sidebar">
    <div class="nav-header">
      <p class="logo">JustU</p>
      <img src="./assets/images/JustU logo.png" alt="JustU logo" id="justu-logo">
      <i class="bx bx-menu btn-menu"></i>
    </div>
    <ul class="nav-links">
      <li>
        <i class="bx bx-search search-btn"></i>
        <input type="text" placeholder="Search..." />
        <span class="tooltip">Search</span>
      </li>
      <li>
        <a href="index.php">
          <i class="bx bx-home-alt-2"></i>
          <span class="title">Home Page</span>
        </a>
        <span class="tooltip">Home Page</span>
      </li>
      <li>
        <a href="#">
          <i class="bx bx-plus-circle"></i>
          <span class="title">Create</span>
        </a>
        <span class="tooltip">Create</span>
      </li>
      <li>
        <a href="#">
          <i class="bx bx-bookmark"></i>
          <span class="title">Bookmarks</span>
        </a>
        <span class="tooltip">Bookmarks</span>
      </li>
      <li>
        <a href="./public/profile.php">
          <i class="bx bx-user-circle"></i>
          <span class="title">Profile</span>
        </a>
        <span class="tooltip">Profile</span>
      </li>
      <li>
        <a href="./public/settings.php">
          <i class="bx bx-cog"></i>
          <span class="title">Settings</span>
        </a>
        <span class="tooltip">Settings</span>
      </li>
      <li>
        <a href="./public/signin.php">aa
        </a>
      </li>
    </ul>
  </section>

  <script src="./assets/js/index.js"></script>
  <script src="./assets/js/settings.js"></script>

</body>

</html>