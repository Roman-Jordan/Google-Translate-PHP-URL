<?php
class Translate{
  
  function __construct($languages){
    foreach($languages as $key => $value){
      $this->$key = $value;
    }
    $this->path = $this->directory. '/supported-languages.json';
  }
  
  function supportedLanguages(){
      
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

    //Defaults
    $class = isset($this->class) ? 'class="'.$this->class.'"': false;
    $tag = isset($this->tag) ? $this->tag : 'button';
    $href = isset($this->href) ? $this->href : false; 
    $pull = file_get_contents($this->path);
    $decoded = json_decode($pull);
    $html = "";
    foreach($decoded->data->languages as $language){
      if($language->name !== NULL){
        $id = isset($this->id) ? 'id="'.$this->id.'-'.$language->language.'"': false;
        $html .= '<'.$this->tag.' '.$class.' '.$id.' value="'.$language->language.'">'.$language->name.'</'.$this->tag.'>';
      }
    }
    echo $html;
  }
}
