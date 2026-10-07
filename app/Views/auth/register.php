<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<section class="page-intro">
    <div class="container narrow">
        <p class="eyebrow">Daftar</p>
        <h1>Buat akun user</h1>
        <p><?= esc($description) ?></p>
    </div>
</section>

<section class="section">
    <div class="container narrow">
        <article class="panel">
            <?php if (session()->getFlashdata('error')): ?>
                <div class="alert alert--error"><?= esc(session()->getFlashdata('error')) ?></div>
            <?php endif; ?>
            <p class="auth-copy">Form ini untuk akun user/donatur. Email admin Google tidak bisa didaftarkan di sini.</p>
            <form class="donation-form donation-form--single" action="<?= site_url('register') ?>" method="post">
                <?= csrf_field() ?>
                <label class="form-field">
                    <span>Nama</span>
                    <input type="text" name="name" value="<?= old('name') ?>" placeholder="Nama lengkap">
                </label>
                <label class="form-field">
                    <span>Email</span>
                    <input type="email" name="email" value="<?= old('email') ?>" placeholder="nama@email.com">
                </label>
                <label class="form-field">
                    <span>No. HP</span>
                    <input type="text" name="phone" value="<?= old('phone') ?>" placeholder="08xxxxxxxxxx">
                </label>
                <label class="form-field">
                    <span>Password</span>
                    <input type="password" name="password" placeholder="Minimal 8 karakter">
                </label>
                <button class="button button--primary" type="submit">Daftar</button>
            </form>
        </article>
    </div>
</section>
<?= $this->endSection() ?>
