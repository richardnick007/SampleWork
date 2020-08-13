<!DOCTYPE html>
<html lang="en-US" dir="ltr">

<meta http-equiv="content-type" content="text/html;charset=utf-8" />

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- ===============================================-->
    <!--    Document Title-->
    <!-- ===============================================-->
    <title>Sample work | Documentation &amp;</title>

    <!-- ===============================================-->
    <!--    Favicons-->
    <!-- ===============================================-->
    <!-- <link rel="apple-touch-icon" sizes="180x180" href="../assets/img/favicons/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="../assets/img/favicons/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="../assets/img/favicons/favicon-16x16.png">
    <link rel="shortcut icon" type="image/x-icon" href="../assets/img/favicons/favicon.ico">
    <link rel="manifest" href="../assets/img/favicons/manifest.json">
    <meta name="msapplication-TileImage" content="../assets/img/favicons/mstile-150x150.png">
    <meta name="theme-color" content="#ffffff"> -->

    <!-- ===============================================-->
    <!--    Stylesheets-->
    <!-- ===============================================-->
    <link
    <link href="../assets/css/theme.css" rel="stylesheet">
</head>

<body>
    <!-- ===============================================-->
    <!--    Main Content-->
    <!-- ===============================================-->
    <main class="main" id="top">

        <div class="container">
            <div class="navbar-vertical-wrapper"></div>

            <div class="content">
                <nav
                    class="navbar navbar-light navbar-glass fs--1 font-weight-semi-bold row navbar-top sticky-kit navbar-expand">
                    <button class="navbar-toggler collapsed" type="button" data-toggle="collapse"
                        data-target="#navbarVerticalCollapse" aria-controls="navbarVerticalCollapse"
                        aria-expanded="false" aria-label="Toggle navigation"><span
                            class="navbar-toggler-icon"></span></button><a class="navbar-brand text-left ml-3"
                        href="../index-2.html">
                        <div class="d-flex align-items-center"><img class="mr-2"
                                src="../assets/img/illustrations/falcon.png" alt="" width="40" /><span
                                class="text-sans-serif">SampleWork</span></div>
                    </a>
                    <div class="collapse navbar-collapse" id="navbarNavDropdown1">

                        <ul class="navbar-nav align-items-center ml-auto">

                        </ul>
                    </div>
                </nav>
                <div class="card mb-3">
                    <div class="bg-holder d-none d-lg-block bg-card"
                        style="background-image:url(../assets/img/illustrations/corner-4.png);"></div>
                    <!--/.bg-holder-->
                    <div class="card-body">
                        <div class="row">
                            <div class="col-lg-8">
                                <h3 class="mb-0">Getting started</h3>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card mb-3">
                    <div class="card-header">
                        <h5 class="mb-0 contains-anchor" id="quick-start">Quick start<a href="#quick-start"
                                data-fancyscroll data-offset="96">#</a></h5>
                    </div>
                    <div class="card-body bg-light">
                        <p class="mb-0">Looking to start using our endpoints quickly? Just follow the documentation below
                            </p>
                    </div>
                </div>
                <div class="card mb-3">
                    <div class="card-header">
                        <h5 class="mb-0 contains-anchor" id="setting-up-build-system">Using the SampleWork API<a
                                href="#setting-up-build-system" data-fancyscroll data-offset="96">#</a></h5>
                    </div>
                    <div class="card-body bg-light">
                        <p>To get List of Transactions, use these endpoints</p>
                        <pre><code class="lang-html">https://samplework.fscrtrade.com/api/register</code></pre>
                        <p class="mt-4">API endpoint to *Rigister* a user with the provided credentials
                            A successful registration will result in a *HTTP 200* Status code
                            Request for a non existing user will return HTTP 400 status<br>
                            <i>*Credentials*</i><br>
                            <ol>
                                <li>Fullname*</li>
                                <li>Email*</li>
                                <li>Password*</li>
                                <li>Confirm_password*</li>
                            </ol>
                        </p>
                    </div>
                    <hr>
                    <div class="card-body bg-light">
                        <p>To get List of Transactions, use these endpoints</p>
                        <pre><code class="lang-html">https://samplework.fscrtrade.com/api/login</code></pre>
                        <p class="mt-4">> A successful login will result in a *HTTP 200* Status code
                        Request for a non existing user or wrong credentials will return HTTP 400 status<br>
                            <i>*Credentials*</i><br>
                            <ol>
                                <li>Email*</li>
                                <li>Password*</li>
                            </ol>
                        </p>
                    </div>
                    <hr>
                    <div class="card-body bg-light">
                        <p>For Transfer, use these endpoints</p>
                        <pre><code class="lang-html">https://samplework.fscrtrade.com/api/transfer</code></pre>
                                              
                   

                        <p class="mt-4">...API endpoint to *transfer* initiate the transfer process. A successful transfer will result in a *HTTP 200* Status code <br>A failed transfer will return HTTP 400 status
                        </p>

                    </div>
                    <hr>
                    <div class="card-body bg-light">
                        <p>To get List of Transactions, use these endpoints</p>
                        <pre><code class="lang-html">https://samplework.fscrtrade.com/api/transactions</code></pre>
                        <p class="mt-4">API endpoint to *transactions* API request gets all users transactions<br>
                            A successful API request will return all transactions and *HTTP 200* Status code<br>
                            A failed request will return HTTP 400 status
                        </p>
                    </div>
                    <hr>
                    <div class="card-body bg-light">
                        <p>For Transfer, use these endpoints</p>
                        <pre><code class="lang-html">https://samplework.fscrtrade.com/api/transfers/name</code></pre>
                                              
                   

                        <p class="mt-4">API endpoint to *transfer/name* search for a particular transaction using name as parameter.<br>
                        A successful API request will return transactions for that particular name<br>
                        Request for a non existing name will return HTTP 404 status
                        </p>

                    </div>
                  
                </div>
            </div>

        </div>
    </main>

</body>



</html>