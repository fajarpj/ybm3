<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<section class="page-intro">
    <div class="container narrow">
        <p class="eyebrow">Login</p>
        <h1>Masuk ke dashboard</h1>
        <p><?= esc($description) ?></p>
    </div>
</section>

<section class="section">
    <div class="container narrow">
        <article class="panel">
            <?php if (session()->getFlashdata('error')): ?>
                <div class="alert alert--error"><?= esc(session()->getFlashdata('error')) ?></div>
            <?php endif; ?>
            <?php if (session()->getFlashdata('success')): ?>
                <div class="alert alert--success"><?= esc(session()->getFlashdata('success')) ?></div>
            <?php endif; ?>

            <form class="donation-form donation-form--single" action="<?= site_url('login') ?>" method="post">
                <?= csrf_field() ?>
                <label class="form-field">
                    <span>Email</span>
                    <input type="email" name="email" value="<?= old('email') ?>" placeholder="nama@email.com" autocomplete="email" required>
                </label>
                <label class="form-field">
                    <span>Password</span>
                    <input type="password" name="password" placeholder="Password" autocomplete="current-password" required>
                </label>
                <button class="button button--primary" type="submit">Login</button>
            </form>
            <p class="auth-hint">Belum punya akun? <a href="<?= site_url('register') ?>">Daftar di sini</a>.</p>
        </article>
    </div>
</section>
<?= $this->endSection() ?>
