<?
namespace Concrete\Core\Html;

class Image
{

    protected $usePictureTag = false;
    protected $tag;

    protected $theme;

    protected function loadPictureSettingsFromTheme()
    {
        $c = \Page::getCurrentPage();
        if (is_object($c)) {
            $th = $c->getCollectionThemeObject();
            if (is_object($th)) {
                $this->theme = $th;
                $this->usePictureTag = count($th->getThemeResponsiveImageMap()) > 0;
            }
        }
    }

    /**
     * @param \File $f
     * @param null $usePictureTag
     */
    public function __construct(\File $f, $usePictureTag = null)
    {
        if (isset($usePictureTag)) {
            $this->usePictureTag = $usePictureTag;
        } else {
            $this->loadPictureSettingsFromTheme();
        }

        if ($this->usePictureTag) {

            if (!isset($this->theme)) {
                $c = \Page::getCurrentPage();
                $this->theme = $c->getCollectionThemeObject();
            }
            $sources = array();
            foreach($this->theme->getThemeResponsiveImageMap() as $thumbnail => $width) {
                $type = \Concrete\Core\File\Image\Thumbnail\Type\Type::getByHandle($thumbnail);
                $src = $f->getThumbnailURL($type->getBaseVersion());
                $sources[] = array('src' => $src, 'width' => $width);
                if ($width == 0) {
                    $fallbackSrc = $src;
                }
            }
            $this->tag = \Concrete\Core\Html\Object\Picture::create($sources, $fallbackSrc);
        } else {
            // Return a simple image tag.
            $this->tag = \HtmlObject\Image::create($f->getRelativePath());
            $this->tag->width($f->getAttribute('width'));
            $this->tag->height($f->getAttribute('height'));
        }
    }

    /**
     * @return \HTMLObject\Element\Tag
     */
    public function getTag()
    {
        return $this->tag;
    }

}