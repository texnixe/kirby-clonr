<?php

/**
* Clone Field for Kirby CMS (v. 2.3.0)
*
* @author    Sonja Broda - info@exniq.de
* @version   1.0
*
*/

class ClonrField extends BaseField {

  static public $fieldname = 'clonr';

  static public $assets = array(
    'js' => array(
      'script.js',
    ),
    'css' => array(
      'style.css',
    )
  );

  public function input() {

    $site = kirby()->site();

    $html = tpl::load( __DIR__ . DS . 'template.php', $data = array(
      'field' => $this,
      'page' => $this->page(),
      'placeholder'  => $this->i18n($this->placeholder()),
      'buttontext' => $this->i18n($this->buttontext()),
    ));
    return $html;
  }

  public function result() {
    return null;
  }

  public function element() {
    $element = parent::element();
    $element->data('field', self::$fieldname);
    return $element;
  }


  public function getData($lang = null) {
    $site = kirby()->site();
    if($site->multilang()) {
      $dLangCode = $site->defaultLanguage()->code();
      return $this->page()->content($dLangCode)->toArray();
    } if(is_string($lang)) {
      return $this->page()->content($lang)->toArray();
    } else {
      return $this->page()->content()->toArray();
    }

  }

  public function updatePage($newPage, $newID) {
    $site = kirby()->site();
    foreach($site->languages() as $lang) {
      if($lang !== $site->defaultLanguage()) {
        $data = $this->getData($lang->code());
        $data['title'] = urldecode($newID);
        try {
          $newPage->update($data, $lang->code());
          return true;
        } catch(Exception $e) {
          return false;
        }
      }
    }
  }


  public function copyPage($newID) {

    $site = kirby()->site();
    $page = $this->page();

    // get page data
    $data = $this->getData();
    $data['title'] = urldecode($newID);


    try {

      $newPage = $page->siblings()->create(str::slug(urldecode($newID)), $page->intendedTemplate(), $data);

      if($site->multilang()) {
        $this->updatePage($newPage, $newID);
      }

      // trigger panel.page.create event
      kirby()->trigger('panel.page.create', $newPage);

      $response = array(
        'message' => 'The new page was created. ',
        'class' => 'success',
        'uri' => $newPage->uri()
      );

    } catch(Exception $e) {

      $response = array(
        'message' => $e->getMessage(),
        'class' => 'error'
      );

    }


    return $response;
  }

  // Routes
  public function routes() {
    return array(
      array(
        'pattern' => 'api/clonr/(:any)',
        'method'  => 'GET',
        'action' => function($newID) {

          $response = $this->copyPage($newID);

          return json_encode($response);

        }
        )
      );

    }
  }
