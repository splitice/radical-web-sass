<?php
namespace Radical\Web;

class Sass {
	private static function getFunctions($extensions) {
		$output = array ();
		if (! empty ( $extensions )) {
			foreach ( $extensions as $extension ) {
				$name = explode ( '/', $extension, 2 );
				$namespace = ucwords ( preg_replace ( '/[^0-9a-z]+/', '_', strtolower ( array_shift ( $name ) ) ) );
				global $BASEPATH;
				$sass_path = $BASEPATH.'/vendor/richthegeek/phpsass/tree/Extensions/';
				$extensionPath = $sass_path.'/' . $namespace . '/' . $namespace . '.php';
				if (file_exists ( $extensionPath )) {
					require_once ($extensionPath);
					$namespace = $namespace . '::';
					$function = 'getFunctions';
					$output = array_merge ( $output, call_user_func ( $namespace . $function, $namespace ) );
				}
			}
		}
	
		return $output;
	}
	
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