
<?php 

class Translate{
  
  function __construct($languages){
    foreach($languages as $key => $value){
      $this->$key = $value;
    }
    $this->path = $this->directory. '/supported-languages.json';
  }

  function supportedLanguages(){
    //Defaults
    $class = isset($this->class) ? 'class="'.$this->class.'"': false;
    $id = isset($this->id) ? 'id="'.$this->id.'"': false;
    $dir = isset($this->dir) ? $this->dir : 'languages';
    $tag = isset($this->tag) ? $this->tag : 'button';
    $href = isset($this->href) ? $this->href : false; 
    
    if(file_exists($this->path)){
        $this->escapeHTML();
    }else{
        $this->toNative();
    }  
  }

  function toNative(){
    $pull = file_get_contents("https://translation.googleapis.com/language/translate/v2/languages?target=en&key=".$this->apiKey);
    $languageList = json_decode($pull);
    
    foreach($languageList->data->languages as $language){
      
      $languageToNative = @file_get_contents('https://translation.googleapis.com/language/translate/v2/?target='.$language->language.'&q='.$language->name.'&key='.$this->apiKey);
      if($languageToNative === false){
        $language->name = NULL;
      }else{
        $nativeLang = json_decode($languageToNative);
        foreach($nativeLang->data->translations as $lang){
          $language->name = $lang->translatedText;
        }
      }
    }
    
    $file = fopen($this->path, "w") or die("Unable to open file!");
    fwrite($file, json_encode($languageList));
    fclose($file);
    
    $this->escapeHTML();
  }

  function escapeHTML(){
    
    $pull = file_get_contents(__DIR__.'/'.$this->path);
    $decoded = json_decode($pull);
    $html = "";
    foreach($decoded->data->languages as $language){
      if($language->name !== NULL){
        $html .= '<'.$this->tag.' '.$this->class.' '.$this->id.' value="'.$language->language.'">'.$language->name.'</'.$this->tag.'>';
      }
    }
    ECHO $html;
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
              <?php echo $translate->supportedLanguages($languages);?>
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

