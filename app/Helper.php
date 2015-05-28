<?php namespace MyPlugin;

class Helper {

    /**
     * The booted state.
     *
     * @var boolean
     */
    protected static $booted = false;

    /**
     * The base path.
     *
     * @var string
     */
    protected static $base;

    /**
     * The herbert.config.php content.
     *
     * @var array
     */
    protected static $config = [];

    /**
     * Boots the Helper.
     */
    public static function boot()
    {
        self::$base = substr(plugin_dir_url(__FILE__), strlen(home_url()));
        self::$base = dirname(self::$base);
        self::$base = rtrim(ABSPATH, '/') . self::$base . '/';

        self::$config = @require self::$base . '/herbert.config.php';

        self::$booted = true;
    }

    /**
     * Gets a config variable.
     *
     * @param  string $key
     * @param  mixed  $default
     * @return mixed
     */
    public static function get($key = null, $default = null)
    {
        if ( ! self::$booted)
        {
            self::boot();
        }

        if ($key === null)
        {
            return self::$config;
        }

        return array_get(self::$config, $key, $default);
    }

    /**
     * Gets a path to a relative file.
     *
     * @param  string $file
     * @return string
     */
    public static function path($file)
    {
        if ( ! self::$booted)
        {
            self::boot();
        }

        return self::$base . $file;
    }

    /**
     * Gets a path to a relative asset.
     *
     * @param  string $file
     * @return string
     */
    public static function asset($file = null)
    {
        $asset = trim(self::get('assets', 'assets'), '/');

        if ($file !== null)
        {
            $asset .= '/' . trim($file, '/');
        }

        return self::path($asset);
    }

    /**
     * Gets a url to a relative asset.
     *
     * @param  string $file
     * @return string
     */
    public static function assetUrl($file = null)
    {
        return rtrim(home_url(), '/') . '/' . substr(self::asset($file), strlen(ABSPATH));
    }

}
