        <footer>
            <?php 
            $endtm = microtime(TRUE);
            $time_taken =($endtm - $strldp);
            $time_taken = round($time_taken,3);
            echo 'Page loaded in '.$time_taken.' seconds';
            ?>
            / copyright @ <a href="https://www.youtube.com/channel/UCerHCbhElFF6LVK_00WPd8A">HPQ123</a>
        </footer>
    </section>
    <script src="<?= Config::$URL ?>assets/js/vendor-all.min.js"></script>
    <script src="<?= Config::$URL ?>assets/plugins/bootstrap/js/bootstrap.min.js"></script>
    <script src="<?= Config::$URL ?>assets/js/pcoded.min.js"></script>
    <script src="<?= Config::$URL ?>assets/js/sweetalert2.all.js"></script>
    <script src="https://kit.fontawesome.com/bb14b36fb4.js" crossorigin="anonymous"></script>
    <script type="text/javascript">
        $(document).on('click', '#discord', function() {
            window.location.href='https://discord.gg/Y6mdANW7Nj';
        });
    </script>
</body>
</html>