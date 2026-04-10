<div class="wrap about-wrap">
    <h1><?php esc_html_e( 'Reduk Framework - A Community Effort', 'wpstr_framework' ); ?></h1>

    <div class="about-text">
        <?php esc_html_e( 'We recognize we are nothing without our community. We would like to thank all of those who help Reduk to be what it is. Thank you for your involvement.', 'wpstr_framework' ); ?>
    </div>
    <div class="reduk-badge">
        <i class="el el-reduk"></i>
        <span>
            <?php printf( __( 'Version %s', 'wpstr_framework' ), esc_html(RedukFramework::$_version )); ?>
        </span>
    </div>

    <?php $this->actions(); ?>
    <?php $this->tabs(); ?>

    <p class="about-description">
        <?php echo sprintf( __( 'Reduk is created by a community of developers world wide. Want to have your name listed too? <a href="%d" target="_blank">Contribute to Reduk</a>.', 'wpstr_framework' ), 'https://github.com/redukframework/reduk-framework/blob/master/CONTRIBUTING.md' );?>
    </p>

    <?php echo wp_kses_post($this->contributors()); ?>
</div>