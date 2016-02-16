<?php
/**
 * SkinTemplate class for the Softcatala skin
 *
 * @ingroup Skins
 */
class SkinSoftcatala extends SkinTemplate {
	public $skinname = 'softcatala', $stylename = 'Softcatala',
		$template = 'SoftcatalaTemplate', $useHeadElement = true;

	/**
	 * Add CSS via ResourceLoader
	 *
	 * @param $out OutputPage
	 */
	public function initPage( OutputPage $out ) {

		$out->addMeta( 'viewport', 'width=device-width, initial-scale=1.0' );

		$out->addModuleStyles( array(
			'mediawiki.skinning.interface',
			'mediawiki.skinning.content.externallinks',
			'skins.softcatala'
		) );
		$out->addModules( array(
			'skins.softcatala.js'
		) );

		$out->addHeadItem( 'common_header_sc', $this->getCommonHeader());
	}

	/**
	 * @param $out OutputPage
	 */
	function setupSkinUserCss( OutputPage $out ) {
		parent::setupSkinUserCss( $out );
	}

	/**
	 *
	 *
	 */
	function getCommonHeader()
	{
		$header = '<!-- .pag-header -->
    <header class="pag-header cd-main-header">
      <!-- navbar -->
      <nav class="navbar">

          <!-- .wrap-gris .hidden-xs -->
          <div class="wrap-gris hidden-xs">
            <div class="container-fluid">

              <!-- .navbar-noticies .hidden-xs -->
              <div class="navbar-noticies">
                <ul class="nav navbar-nav">
                  <li><a href="/noticies/">Notícies</a></li>
                  <li><a href="/esdeveniments/">Esdeveniments</a></li>
                  <li><a href="#">Premsa</a></li>
                  <li><a href="#">Fòrums</a></li>
                </ul>
              </div><!--/.navbar-noticies .hidden-xs -->
            </div><!--/.container-fluid -->
          </div><!--/.wrap-gris -->

          <!--#include virtual="/ssi/menu-header.html" -->
    </header><!--/.pag-header -->';

    	return $header;
	}
}
