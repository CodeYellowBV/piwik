<?php
/**
 * Piwik - Open source web analytics
 *
 * @link http://piwik.org
 * @license http://www.gnu.org/licenses/gpl-3.0.html GPL v3 or later
 *
 */
namespace Piwik\Plugins\UserCountry\Reports;

use Piwik\Piwik;
use Piwik\Plugin\ViewDataTable;
use Piwik\Plugins\UserCountry\Columns\Country;
use Piwik\Plugins\UserCountry\LocationProvider;

class GetCountry extends Base
{
    protected function init()
    {
        parent::init();
        $this->dimension     = new Country();
        $this->name          = Piwik::translate('UserCountry_Country');
        $this->documentation = ''; // TODO
        $this->metrics       = array('nb_visits', 'nb_uniq_visitors', 'nb_actions');
        $this->order = 5;
        $this->widgetTitle = Piwik::translate('UserCountry_WidgetLocation')
                           . ' (' . Piwik::translate('UserCountry_Country') . ')';
    }

    public function configureView(ViewDataTable $view)
    {
        $view->config->show_goals = true;
        $view->config->show_exclude_low_population = false;
        $view->config->addTranslation('label', Piwik::translate('UserCountry_Country'));
        $view->config->documentation = Piwik::translate('UserCountry_getCountryDocumentation');

        $view->requestConfig->filter_limit = 5;

        if (LocationProvider::getCurrentProviderId() == LocationProvider\DefaultProvider::ID) {
            // if we're using the default location provider, add a note explaining how it works
            $footerMessage = Piwik::translate("General_Note") . ': '
                . Piwik::translate('UserCountry_DefaultLocationProviderExplanation',
                    array('<a target="_blank" href="http://piwik.org/docs/geo-locate/">', '</a>'));

            $view->config->show_footer_message = $footerMessage;
        }
    }

}