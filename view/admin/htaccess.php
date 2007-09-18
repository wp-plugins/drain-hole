<IfModule mod_rewrite.c>
RewriteEngine On
RewriteRule ^(.*)$ <?php echo $index; ?>

</IfModule>
