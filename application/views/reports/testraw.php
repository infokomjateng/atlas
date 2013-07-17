<html>
    <head>
        <script type="text/javascript" src="<?= base_url() ?>includes/js/files/jquery-1.7.1.js"></script>
    </head>
    <input name="urlraw" id="urlraw" /><input type="button" value="submit" name="submit" onclick="$.get($('#urlraw').val(), function(a) { $('#testraw').val(a) })" id="submit" />
    <textarea style="width:100%; height: 500px" id="testraw">
dfsdfd
    </textarea>
</html>