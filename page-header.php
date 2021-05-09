<nav class="navbar navbar-expand-lg navbar-light bg-light">
  <a class="navbar-brand" href="index.php">DM Tools</a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>

  <div class="collapse navbar-collapse" id="navbarSupportedContent">
    <ul class="navbar-nav mr-auto">
      <li class="nav-item active">
        <a class="nav-link" href="index.php">Home <span class="sr-only">(current)</span></a>
      </li>
        <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          Campaigns
        </a>
        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
          <a class="dropdown-item disabled" href="mycampaigns.php">My Campaigns (coming soon)</a>
<!--
          <div class="dropdown-divider"></div>
          <a class="dropdown-item" href="#">Something else here</a>
-->
        </div>
      </li>
        <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          Characters
        </a>
        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
          <a class="dropdown-item" href="mycharacters.php">My Characters</a>
<!--
          <div class="dropdown-divider"></div>
          <a class="dropdown-item" href="#">Something else here</a>
-->
        </div>
      </li>
      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          Retainers
        </a>
        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
            <a class="dropdown-item" href="myretainers.php">My Retainers</a>
            <a class="dropdown-item" href="retainertypes.php">Retainer Types</a>
            <a class="dropdown-item" href="create_retainer.php">Create Retainer</a>
            <a class="dropdown-item" href="create_retainer_type.php">Create Retainer Type</a>
            <a class="dropdown-item" href="quickretainercreator.php">Quick Retainer Creator</a>
<!--
          <div class="dropdown-divider"></div>
          <a class="dropdown-item" href="#">Something else here</a>
-->
        </div>
      </li>
            <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          Armies
        </a>
        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
          <a class="dropdown-item disabled" href="myarmies.php">My Armies (coming soon)</a>
<!--
          <div class="dropdown-divider"></div>
          <a class="dropdown-item" href="#">Something else here</a>
-->
        </div>
      </li>
<!--
    <li class="nav-item">
        <a class="nav-link disabled" href="#">Disabled</a>
    </li>
-->
        <?php if (!isset($_SESSION['username'])) : ?>
    <li class="nav-item">
        <a class="nav-link" href="login.php">Login</a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="register.php">Register</a>
    </li>
        <?php else: ?>
    
    <li class="nav-item">
        <a class="nav-link" href="user.php" style="color:blue;"><?php echo $_SESSION['username']; ?></a>
    </li>
    <li class="nav-item">
        <p><a class="nav-link" href="index.php?logout=1" style="color: red;">Logout</a></p>
    </li>
        <?php endif ?>
    </ul>
<!--
    <form class="form-inline my-2 my-lg-0">
      <input class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search">
      <button class="btn btn-outline-success my-2 my-sm-0" href="login.php">Login</button>
    </form>
-->
  </div>

</nav> 
<hr>
