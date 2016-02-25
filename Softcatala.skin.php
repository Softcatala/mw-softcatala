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
		$header = '<!--#include virtual="/ssi/menu-header.html" -->';

    	return $header;
	}
}
