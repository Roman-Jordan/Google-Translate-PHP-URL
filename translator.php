
<?php 

class Translate{
  function supportedLanguages($languages){
    
    $class = isset($languages['class']) ? 'class="'.$languages['class'].'"': false;
    $id = isset($languages['id']) ? 'id="'.$languages['id'].'"': false;
    $dir = isset($languages['dir']) ? $languages['dir'] : 'languages';
    $tag = isset($languages['tag']) ? $languages['tag'] : 'button';
    $href = isset($languages['href']) ? $languages['href'] : false;
    
    $path = $dir.'/supported-languages.json';
    
    if(file_exists($path)){
        $pull = file_get_contents($path);
        $decoded = json_decode($pull);
        $html = "";
        foreach($decoded->data->languages as $language){
            $html .= '<'.$tag.' '.$class.' '.$id.' value="'.$language->language.'">'.$language->name.'</'.$tag.'>';
        }
        return $html;
    }else{
        $this->toNative($languages);
    }  
    return 'complete';  
  }

  function toNative($languages){
    $pull = file_get_contents("https://translation.googleapis.com/language/translate/v2/languages?target=en&key=".$languages['apiKey']);
    $languageList = json_decode($pull);
    foreach($languageList->data->languages as $language){
      $languageToNative = file_get_contents('https://translation.googleapis.com/language/translate/v2/?target='.$language->language.'&q='.$language->name.'&key='.$languages['apiKey']);
      $nativeLang = json_decode($languageToNative);
      foreach($nativeLang->data->translations as $lang){
        $language->name = $lang->translatedText;
        $html .= '<'.$tag.' '.$class.' '.$id.' value="'.$language->language.'">'.$language->name.'</'.$tag.'>';
      }
    }
    $file = fopen("languages/supported-languages.json", "w") or die("Unable to open file!");
    fwrite($file, json_encode($languageList));
    fclose($file);
    $this->supportedLanguages($languages);
  }
}

$apiKey ="AIzaSyAKhbhxW7u3u7q4QkiVDGQk3ZByDtUkbhg";

$languages = array(
    'apiKey'    => $apiKey,
    'directory' => 'languages',
    'tag'       => 'button',
    'class'     => 'tx btn-link',
    'update'    => 'update',
    'id'        => 'Hello'
);

$translate = new Translate();
?>
 

 <!DOCTYPE html>
<html lang="en" style="height:100%;" wp-site wp-site-is-master-page>
    <head>
        <meta charset="utf-8">
        <title>FarmHealth Technologies</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="keywords" content="pinegrow, blocks, bootstrap" />
        <meta name="description" content="My new website" />
        <link rel="shortcut icon" href="ico/favicon.png">
        <!-- Core CSS -->
        <link href="bootstrap/css/bootstrap.min.css" rel="stylesheet">
        <link href="css/font-awesome.min.css" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,600italic,700italic,400,300,600,700" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css?family=Lato:300,400,700,300italic,400italic,700italic" rel="stylesheet">
        <!-- Style Library -->
        <link href="css/style-library-1.css" rel="stylesheet">
        <link href="css/plugins.css" rel="stylesheet">
        <link href="css/blocks.css" rel="stylesheet">
        <link href="css/custom.css" rel="stylesheet">
        <!-- HTML5 shim, for IE6-8 support of HTML5 elements. All other JS at the end of file. -->
        <!--[if lt IE 9]>
      <script src="js/html5shiv.js"></script>
      <script src="js/respond.min.js"></script>
    <![endif]-->
    </head>
    <body data-spy="scroll" data-target="nav">
        <header id="header-3" class="soft-scroll header-3" wp-cz-section="blocks_header_3" wp-cz-section-title="Header 3">
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
        </header>
     
        <!--Modal-->
         <!-- Modal -->
  <div class="modal fade" id="translate-modal" role="dialog">
        <div class="modal-dialog">
        
          <!-- Modal content-->
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal">&times;</button>
              <h4 class="modal-title">Please Select a language</h4>
            </div>
            <div class="modal-body" id="languages">
              <?php echo $translate->supportedLanguages($languages);?>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
          </div>
          
        </div>
      </div>
      
    </div>



        <!--/Modal-->
        <script type="text/javascript" src="js/jquery-1.11.1.min.js"></script>
        <script type="text/javascript" src="js/bootstrap.min.js"></script>
        <script type="text/javascript" src="js/plugins.js"></script>
        <script src="https://maps.google.com/maps/api/js?sensor=true"></script>
        <script type="text/javascript" src="js/bskit-scripts.js"></script>
        
    </body>
</html>

