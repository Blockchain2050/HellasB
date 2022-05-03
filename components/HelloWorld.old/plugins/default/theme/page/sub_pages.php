<?php

/**
 * Open Source Social Network
 *
 * @package   (softlab24.com).ossn
 * @author    OSSN Core Team <info@softlab24.com>
 * @copyright (C) SOFTLAB24 LIMITED
 * @license   Open Source Social Network License (OSSN LICENSE)  http://www.opensource-socialnetwork.org/licence
 * @link      https://www.opensource-socialnetwork.org/
 */
$sitename = ossn_site_settings('site_name');
$sitelanguage = ossn_site_settings('language');
if (isset($params['title'])) {
  $title = $params['title'] . ' : ' . $sitename;
} else {
  $title = $sitename;
}
if (isset($params['contents'])) {
  $contents = $params['contents'];
} else {
  $contents = '';
}
?>

<!DOCTYPE html>
<html>

<head>
  <title>Σελίδες με συνδρομή</title>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <style>
    body * {
      margin: 0;
      padding: 0;
    }

    body {
      background-color: #eaeaea;
    }

    /* container */
    .container {
      display: flex;
      flex-direction: column;
      justify-content: center;
    }

    /* topbar */
    .topbar {
      height: 90px;
      background-color: #0763e5;
      text-align: center;
      font-size: 4rem;
      font-weight: 600;
      color: white;
      margin-bottom: 5%;
    }

    /* pages */
    .pages {
      display: flex;
      flex-direction: column;
      justify-content: center;
      align-items: center;

    }

    /* card */
    .card {
      box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2);
      transition: 0.3s;
      width: 30%;
      border-radius: 5px;
      display: flex;
      flex-direction: column;
      justify-content: center;
    }

    .card:hover {
      box-shadow: 0 8px 16px 0 rgba(0, 0, 0, 0.2);
    }

    img {
      border-radius: 5px 5px 0 0;
      background-color: grey;
      padding-right: 7%;
    }

    .container {
      padding: 2px 16px;
    }

    a {
      color: #dc8100;
      text-decoration: none;
    }

    a:hover {
      color: #333;
      text-decoration: none;
    }

    .return-btn {
      margin-top: 10%;
      margin-left: 20%;
    }

    h4{
      font-size: 1.2rem;
    }
    @media screen and (max-width: 650px) {
      .topbar {
        font-size: 2rem;
        height: 60px;
      }

      .card {
        width: 50%;
      }
    }

    @media screen and (max-width: 356px) {
      .topbar {
        font-size: 2rem;
        height: 50px;
      }

      .card {
        width: 60%;
      }
    }
  </style>
</head>

<body>
  <div class="container">
    <div class="topbar">
      <div>Σελίδες με συνδρομή</div>
    </div>
    <div class="pages">
      <div class="card">
        <a href="https://care4disabled.com/">
        <img src="<?php echo ossn_theme_url(); ?>images/c4d.png"" alt=" Avatar" style="width:93%">
      </a>
        <div class="container">
          
            <h4><b>care4disabled.com</b></h4>
          <p>Προώθηση της κοινωνικής ένταξης των ΑμεΑ και ευαισθητοποίηση σε θέματα ΑμεΑ και εθελοντισμού.</p>
        </div>
      </div>
    </div>
    <div class="return-btn">
      <a style="font-size:40px" href="https://hellasb.com/home">Επιστροφή</a>
    </div>
  </div>
</body>

</html>