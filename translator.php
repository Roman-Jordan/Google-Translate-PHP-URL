
<?php 
require_once('translator_class_library/translate_init.php');

$apiKey ="AIzaSyAKhbhxW7u3u7q4QkiVDGQk3ZByDtUkbhg";

//Set 'directory' if you did not install on server root. E.G public_html/root/someFolder/thisInstall

$languages = array(
    'apiKey'    => $apiKey,
    'directory' => 'git/Google-Translate-PHP-URL',
    'tag'       => 'button',
    'class'     => 'btn-link',
    'update'    => 'update',
    //'id'        => 'Hello'
);

$translate = new Translate($languages);

?>
 

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <title>Translation Catching</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
    </head>
    <body>
        <section>
            <div>
                    <button>Translate</button>
            </div>
            <div>
                <h1 class="tx">I am some text to be translated</h1>
                <p class="tx">I am text to be translated in independent tags 1.</p>
                <p class="tx">I am text to be translated in independent tags 2.</p>
                <p class="tx">I am text to be translated in independent tags 3.</p>
                <p class="tx">I am text to be translated in independent tags 4.</p>
                <p class="tx">I am text to be translated in independent tags 5.</p>
                <p class="tx">I am text to be translated in independent tags 6.</p>
                <p class="tx">I am text to be translated in independent tags 7.</p>
                <p class="tx">I am text to be translated in independent tags 8.</p>
            </div>  

            <div class="modal-body" id="languages">
              <?php echo $translate->supportedLanguages();?>
            </div>

          </section>
          <script>
            let stringsToObj = {};
            document.querySelectorAll(".tx").forEach((string, x) => {
                stringsToObj[x] = !stringsToObj[x] ? string.innerHTML:stringsToObj[x] +1;
            });
            console.log(stringsToObj);
          </script>
    </body>
</html>

