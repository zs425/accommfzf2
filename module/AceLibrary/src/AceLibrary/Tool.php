<?php
/*** Contain a useful static methods ***/
/**
 * @version 1.2
 */
 
namespace AceLibrary;

class Tool
{
    public static function searchdir($path, $maxdepth = 1, $d = 0)
    {
        if (substr($path, strlen($path) - 1) != '/')
            $path .= '/';
        $dirlist = array() ;
        if ($d > 0)
            $dirlist[] = array_pop(explode('/', trim($path, '/')));
        if ($handle = opendir($path)) {
            while(false !==($file = readdir($handle))) {
                if ($file != '.' && $file != '..' && $file != '.svn' && $file != '_svn') {
                    if ($d >=0 &&($d < $maxdepth || $maxdepth < 0)) {
                        if (is_dir($file)) {
                            $result = Ace_Tool::searchdir($path . $file . '/', $maxdepth, $d + 1) ;
                            $dirlist = array_merge($dirlist, $result) ;
                        } else {
                            $dirlist[] = $file;
                        }
                    }
                }
            }
            closedir($handle) ;
        }
        if ($d == 0) { natcasesort($dirlist) ; }
        return($dirlist) ;
    }
    
    /**
     * Creates directory if it not exists 
     * it also creates all parent directories if they not exists
     * @param string $path - absolute path
     */
    public static function createdir($path)
    {
        $intermediate = '';
        foreach (explode('/', $path) as $dir) {
            if(!$dir)
                continue;
            $intermediate .= ('/'.$dir);
            if(!file_exists($intermediate)) 
                mkdir ($intermediate);
        }
    }
    
    public static function getLastModifiedChecksum($files, $dir = null)
    {
        if (!is_array($files))
            $files = array($files);
        // add trailing slash
        if ($dir && (substr($dir, -1, 1) != '/'))
            $dir .= '/'; 
        // get file last modified dates
        $aLastModifieds = array();
        foreach ($files as $sFile) {
         $aLastModifieds[] = filemtime($dir.$sFile);
        }
        // divide sum by files count x 3 to get lower value
        return array_sum($aLastModifieds);
    }
}