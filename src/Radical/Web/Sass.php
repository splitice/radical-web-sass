<?php
namespace Radical\Web;

class Sass {
	static function render($file){
		$ext = pathinfo($file, PATHINFO_EXTENSION);
		$bn = basename ( $file );
		if ($bn {0} == '_')
			return ''; // Importable packages
		
		global $BASEPATH;
		$sass_path = $BASEPATH.'/static/img/sprites/';
		$options = array (
				'style' => 'nested',
				'cache' => false,
				'syntax' => $ext,
				'debug' => false,
				//'load_path_functions' => array('loadCallback'),
				'load_paths' => array($sass_path),
				'functions' => self::getFunctions(array('Compass','Own')),
				'extensions' => array('Compass','Own')
		);
		
		if (\Radical\Core\Server::isProduction ())
			$options ['style'] = 'compressed';
		
		// Execute the compiler.
		$parser = new \SassParser ( $options );
		return $parser->toCss ( $file );
	}
}