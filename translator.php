
<?php 
require_once('translator_class_library/translate_init.php');

$apiKey ="AIzaSyAKhbhxW7u3u7q4QkiVDGQk3ZByDtUkbhg";

$languages = array(
    'apiKey'    => $apiKey,
    'directory' => 'languages',
    'tag'       => 'button',
    'class'     => 'btn-link',
    'update'    => 'update',
    //'id'        => 'Hello'
);

$translate = new Translate($languages);
?>
 

 <!DOCTYPE html>
<html lang="en" style="height:100%;" wp-site wp-site-is-master-page>
    <head>
        <meta charset="utf-8">
        <title>Translation Catching</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
    </head>
    <body data-spy="scroll" data-target="nav">
        <section id="header-3" class="soft-scroll header-3" wp-cz-section="blocks_header_3" wp-cz-section-title="Header 3">
            <!-- /.nav -->
                        <!-- added translator below -->
            <div class="col-md-12">
                    <button type="button" class="btn btn-info btn-lg" data-toggle="modal" data-target="#translate-modal">Translate</button>
            </div>
            <div class="col-md-12">
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

