<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <title>Login - Angsek</title>
    <link href="<?= base_url('assets/sbadmin2/css/sb-admin-2.min.css') ?>" rel="stylesheet">
</head>

<body class="bg-gradient-primary">

<div class="container">

    <div class="row justify-content-center">

        <div class="col-xl-5 col-lg-6 col-md-8">

            <div class="card o-hidden border-0 shadow-lg my-5">
                <div class="card-body p-5">

                    <div class="text-center">
                        <h1 class="h4 text-gray-900 mb-4">Login Angsek</h1>
                    </div>

                    <?php if ($this->session->flashdata('error')): ?>
                        <div class="alert alert-danger"><?= $this->session->flashdata('error'); ?></div>
                    <?php endif; ?>

                   <form method="post" action="<?= site_url('auth/login') ?>">
    <input type="hidden" 
           name="<?= $this->security->get_csrf_token_name(); ?>"
           value="<?= $this->security->get_csrf_hash(); ?>" />


                        <div class="form-group">
                            <input type="text" 
                                   name="username" 
                                   class="form-control form-control-user" 
                                   placeholder="Username..." required>
                        </div>

                        <div class="form-group">
                            <input type="password" 
                                   name="password" 
                                   class="form-control form-control-user" 
                                   placeholder="Password..." required>
                        </div>

                        <button class="btn btn-primary btn-user btn-block">Masuk</button>

                    </form>

                </div>
            </div>

        </div>

    </div>

</div>

<script src="<?= base_url('assets/sbadmin2/vendor/jquery/jquery.min.js') ?>"></script>
<script src="<?= base_url('assets/sbadmin2/vendor/bootstrap/js/bootstrap.bundle.min.js') ?>"></script>
<script src="<?= base_url('assets/sbadmin2/js/sb-admin-2.min.js') ?>"></script>

</body>
</html>
