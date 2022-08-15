<?php
  session_start();

  require 'database.php';

  if (isset($_SESSION['user_id'])) {
    $records = $conn->prepare('SELECT id, username, email,numTelefono,password,accountNumber,money FROM users WHERE id = :id');
    $records->bindParam(':id', $_SESSION['user_id']);
    $records->execute();
    $results = $records->fetch(PDO::FETCH_ASSOC);

    $user = null;

    if (count($results) > 0) {
      $user = $results;
    }
  }
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="shortcut icon" href="/assets/favicon.png" type="image/x-icon" />

    <!-- Link to import the icons -->
    <link
      href="https://unpkg.com/boxicons@2.1.2/css/boxicons.min.css"
      rel="stylesheet"
    />

    <!-- Link for the CSS Bootstrap -->
    <link
      href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css"
      rel="stylesheet"
      integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC"
      crossorigin="anonymous"
    />

    <link rel="stylesheet" href="assets/css/styles_principal.css" />
    <title>iWallet Prog Avz</title>
  </head>
  <body id="body-pd">
    <!-- Preloader -->
    <div id="preloader"></div>
    <!-- Top-Right logo -->
    <header class="header" id="header">
      <div class="header_toggle">
        <i class="bx bx-menu" id="header-toggle"></i>
      </div>
      <div class="header_img">
        <img src="assets/images/logo.png" alt="" />
      </div>
    </header>

    <!-- Navbar -->
    <div class="l-navbar" id="nav-bar">
      <nav class="nav">
        <div>
          <a href="#" class="nav_logo">
            <i class="bx bx-diamond nav_logo-icon"></i>
            <span class="nav_logo-name">iWallet UD</span>
          </a>
          <div class="nav_list">
            <a href="#profile" class="nav_link">
              <i class="bx bx-user nav_icon"></i>
              <span class="nav_name">Profile</span>
            </a>

            <a href="#money" class="nav_link">
              <i class="bx bx-money-withdraw nav_icon"></i>
              <span class="nav_name">Products</span>
            </a>

            <a href="#balance" class="nav_link">
              <i class="bx bx-bar-chart-alt-2 nav_icon"></i>
              <span class="nav_name">Balance</span>
            </a>
          </div>
        </div>
        <a href="LogOut.php" class="nav_link">
          <i class="bx bx-log-out nav_icon"></i>
          <span class="nav_name">Sign Out</span>
        </a>
      </nav>
    </div>

    <!--Container Main start-->
    <main>
      <br />

      <div class="container">
        <section id="profile">
          <div class="leftProfile">
            <img src="assets/images/profile-avatar.png" id="profileImg" alt="" />
            <div id="profileData">
              <h2 id="profileName"><?= $user['username']; ?></h2>
              <h2 id="profileType">Natural</h2>
            </div>
          </div>
          <div class="rightProfile">
            <h2 class="profileTitles">Account Number:</h2>
            <div class="account">
              <p id="accNum" class="blurAcc"><?= $user['accountNumer']; ?></p>
              <i class="bx bx-low-vision bx-tada"></i>
            </div>
            <h2 class="profileTitles">Email:</h2>
            <p id="accEmail"><?= $user['email']; ?></p>
            <h2 class="profileTitles">Phone Number:</h2>
            <p id="accPhone"><?= $user['numTelefono']; ?></p>
          </div>
          <div class="total">Total: $<span id="totalMoney"><?= $user['money']; ?></span></div>
        </section>

        <section id="money">
          <section class="leftMoney">
            <!-- Button that triggers deposit modal -->
            <button
              class="btnM"
              data-bs-toggle="modal"
              data-bs-target="#depositModal"
            >
              Deposit
              <img src="assets/images/depositIcon.png" alt="" />
            </button>

            <!-- Deposit Modal | Pop-Up-->
            <div
              class="modal fade"
              id="depositModal"
              tabindex="-1"
              aria-labelledby="depositModalLabel"
              aria-hidden="true"
              data-bs-backdrop="static"
            >
              <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title" id="depositModalLabel">
                      Deposit Form
                    </h5>
                    <button
                      type="button"
                      class="btn-close"
                      data-bs-dismiss="modal"
                      aria-label="Close"
                    ></button>
                  </div>
                  <div class="modal-body">
                    <form class="needs-validation">
                      <div class="mb-3">
                        <label for="exampleInputEmail1" class="form-label"
                          >Transaction Title</label
                        >
                        <input
                          type="text"
                          class="form-control"
                          id="exampleInputEmail1"
                          aria-describedby="emailHelp"
                          placeholder="e.g. Scholarship"
                          autocomplete="off"
                          required
                        />
                      </div>
                      <div class="mb-3">
                        <label for="exampleInputPassword1" class="form-label"
                          >Amount</label
                        >
                        <input
                          type="currency"
                          class="form-control"
                          id="exampleInputPassword1"
                          placeholder="e.g. 182400"
                          min="1"
                          autocomplete="off"
                          required
                        />
                        <div id="emailHelp" class="form-text">
                          We'll never share your data with anyone else.
                        </div>
                      </div>
                      <div class="mb-3">
                        <h1 class="display-6">Deposit Date:</h1>
                        <h1 class="display-1 text-muted dateInputA"></h1>
                      </div>
                      <button type="submit" class="btn btn-primary">
                        Add <i class="bx bxs-save"></i>
                      </button>
                    </form>
                  </div>
                  <div class="modal-footer"></div>
                </div>
              </div>
            </div>
            <!-- Button that triggers Spend Modal -->

            <button
              class="btnM"
              data-bs-toggle="modal"
              data-bs-target="#spendModal"
            >
              Spend <img src="assets/images/spendIcon.png" alt="" />
            </button>

            <!-- Spend Modal | Pop-Up-->
            <div
              class="modal fade"
              id="spendModal"
              tabindex="-1"
              aria-labelledby="spendModalLabel"
              aria-hidden="true"
              data-bs-backdrop="static"
            >
              <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title" id="spendModalLabel">Spend Form</h5>
                    <button
                      type="button"
                      class="btn-close"
                      data-bs-dismiss="modal"
                      aria-label="Close"
                    ></button>
                  </div>
                  <div class="modal-body">
                    <form class="needs-validation">
                      <div class="mb-3">
                        <label
                          for="spentInputTitle"
                          class="form-label"
                          id="trTitle"
                          >Transaction Title</label
                        >
                        <input
                          type="text"
                          class="form-control"
                          id="spentInputTitle"
                          aria-describedby="transactionHelp"
                          placeholder="e.g. Scholarship"
                          autocomplete="off"
                          required
                        />
                      </div>
                      <div class="mb-3">
                        <label for="spentInputAmount" class="form-label"
                          >Amount</label
                        >
                        <input
                          type="currency"
                          class="form-control"
                          id="spentInputAmount"
                          placeholder="e.g. 182400"
                          min="1"
                          autocomplete="off"
                          required
                        />
                        <div id="transactionHelp" class="form-text">
                          We'll never share your data with anyone else.
                        </div>
                      </div>
                      <div class="mb-3">
                        <h1 class="display-6">Spent Date:</h1>
                        <h1 class="display-1 text-muted dateInputB"></h1>
                      </div>
                      <button type="submit" class="btn btn-primary">
                        Pay <i class="bx bx-credit-card"></i>
                      </button>
                    </form>
                  </div>
                  <div class="modal-footer"></div>
                </div>
              </div>
            </div>
          </section>

          <section class="rightMoney">
            <h1 id="logTitle">Transaction Log</h1>
            <div class="tbl-header">
              <table cellpadding="0" cellspacing="0" border="0">
                <thead>
                  <tr>
                    <th>Title</th>
                    <th>Amount</th>
                    <th>Type</th>
                    <th>Date</th>
                  </tr>
                </thead>
              </table>
            </div>
            <div class="tbl-content">
              <table cellpadding="0" cellspacing="0" border="0">
                <tbody>
                  <tr>
                    <td>AUSTRALIAN COMPANY</td>
                    <td>$1.38</td>
                    <td>DEPOSIT</td>
                    <td>11/07/2022</td>
                  </tr>
                  <tr>
                    <td>AUSENCO</td>
                    <td>$2.38</td>
                    <td>SPEND</td>
                    <td>11/07/2022</td>
                  </tr>
                  <tr>
                    <td>ADELAIDE</td>
                    <td>$3.22</td>
                    <td>SPEND</td>
                    <td>10/07/2022</td>
                  </tr>
                  <tr>
                    <td>ADITYA BIRLA</td>
                    <td>$1.02</td>
                    <td>DEPOSIT</td>
                    <td>10/07/2022</td>
                  </tr>
                  <tr>
                    <td>AUSTRALIAN COMPANY</td>
                    <td>$1.38</td>
                    <td>SPEND</td>
                    <td>10/07/2022</td>
                  </tr>
                  <tr>
                    <td>AUSENCO</td>
                    <td>$2.38</td>
                    <td>DEPOSIT</td>
                    <td>10/07/2022</td>
                  </tr>
                  <tr>
                    <td>ADELAIDE</td>
                    <td>$3.22</td>
                    <td>DEPOSIT</td>
                    <td>10/07/2022</td>
                  </tr>
                  <tr>
                    <td>ADITYA BIRLA</td>
                    <td>$1.02</td>
                    <td>SPEND</td>
                    <td>10/07/2022</td>
                  </tr>
                  <tr>
                    <td>AUSTRALIAN COMPANY</td>
                    <td>$1.38</td>
                    <td>SPEND</td>
                    <td>08/07/2022</td>
                  </tr>
                  <tr>
                    <td>AUSENCO</td>
                    <td>$2.38</td>
                    <td>DEPOSIT</td>
                    <td>08/07/2022</td>
                  </tr>
                  <tr>
                    <td>ADELAIDE</td>
                    <td>$3.22</td>
                    <td>DEPOSIT</td>
                    <td>08/07/2022</td>
                  </tr>
                  <tr>
                    <td>ADITYA BIRLA</td>
                    <td>$1.02</td>
                    <td>SPEND</td>
                    <td>06/07/2022</td>
                  </tr>
                  <tr>
                    <td>AUSTRALIAN COMPANY</td>
                    <td>$1.38</td>
                    <td>SPEND</td>
                    <td>06/07/2022</td>
                  </tr>
                  <tr>
                    <td>AUSENCO</td>
                    <td>$2.38</td>
                    <td>DEPOSIT</td>
                    <td>04/07/2022</td>
                  </tr>
                  <tr>
                    <td>ADELAIDE</td>
                    <td>$3.22</td>
                    <td>DEPOSIT</td>
                    <td>04/07/2022</td>
                  </tr>
                  <tr>
                    <td>ADITYA BIRLA</td>
                    <td>$1.02</td>
                    <td>SPEND</td>
                    <td>04/07/2022</td>
                  </tr>
                  <tr>
                    <td>AUSTRALIAN COMPANY</td>
                    <td>$1.38</td>
                    <td>DEPOSIT</td>
                    <td>02/07/2022</td>
                  </tr>
                  <tr>
                    <td>AUSENCO</td>
                    <td>$2.38</td>
                    <td>SPEND</td>
                    <td>02/07/2022</td>
                  </tr>
                </tbody>
              </table>
            </div>
          </section>
        </section>
        <section id="balance">
          <div id="chartInfo">
            <div id="Chart">
              <canvas id="balanceChart" height="100" width="300"> </canvas>
            </div>
            <div id="Resume">
              <h4 id=" depositMonth" class="resumeTittles">Month</h4>
              <h4 id=" depositAverage" class="resumeTittles">
                Month Average <i class="bx bx-trending-up"></i>
              </h4>
              <div id="depositMonthlist"></div>
              <div id="depositAverageList"></div>
              <h4 id="spendMonth" class="resumeTittles">Month</h4>
              <h4 id=" spendAverage" class="resumeTittles">
                Month Average <i class="bx bx-trending-down"></i>
              </h4>
              <div id="spendMonthlist"></div>
              <div id="spendtAverageList"></div>
            </div>
          </div>
        </section>
      </div>
    </main>
    <!--Container Main end-->

    <footer>
      Developed by
      <a
        id="githubProfile"
        href="https://github.com/Git-Darkmoon"
        target="_blank"
        rel="noopener noreferrer"
        >Nicolas M.</a
      >
      |
      <a
        id="githubProfile"
        href="https://github.com/StormBlessed27"
        target="_blank"
        rel="noopener noreferrer"
        >Hemerson B.</a
      >
      |
      <a
        id="githubProfile"
        href="https://github.com/JuanCarrill0"
        target="_blank"
        rel="noopener noreferrer"
        >Juan C.</a
      >
      ~ Prog Avanzada
    </footer>
  </body>

  <!-- Importing cdn for jQuery -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>

  <!-- Importing cdn JS Bootstrap -->
  <script
    src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM"
    crossorigin="anonymous"
  ></script>

  <!-- Importing chart.js -->
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

  <script defer src="assets/js/app_principal.js"></script>
</html>