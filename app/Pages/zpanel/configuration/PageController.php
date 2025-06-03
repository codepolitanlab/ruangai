<?php 

namespace App\Pages\zpanel\configuration;

use App\Libraries\FormGenerator;
use App\Pages\zpanel\AdminController;
use CodeIgniter\Exceptions\PageNotFoundException;
use Symfony\Component\Yaml\Yaml;

class PageController extends AdminController 
{

	public $data = [
		'page_title' => 'Settings'
	];

    public function getIndex($setting = 'site')
    {
        $this->data['page_title'] = "Settings";
        
        $settingPaths = setting('PanelSettings.settingPaths');
        isset($settingPaths[$setting]) || throw new PageNotFoundException("Setting '$setting' not registered");
        $path = '../' . $settingPaths[$setting]['path'];
        file_exists($path) || throw new PageNotFoundException("Setting file '$setting' not found at {$path}");
        
        $arraySettingConfiguration = Yaml::parseFile($path);
        $Form = new FormGenerator($arraySettingConfiguration);

        $this->data['currentSetting'] = $arraySettingConfiguration;
        $this->data['currentSetting']['name'] = $setting;

        $this->data['settingPaths'] = $settingPaths;
        $this->data['Form'] = $Form;
        
        return pageView('zpanel/configuration/index', $this->data);
    }
}
