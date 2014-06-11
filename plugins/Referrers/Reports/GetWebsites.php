<?php
/**
 * Piwik - Open source web analytics
 *
 * @link http://piwik.org
 * @license http://www.gnu.org/licenses/gpl-3.0.html GPL v3 or later
 *
 */
namespace Piwik\Plugins\Referrers\Reports;

use Piwik\Piwik;
use Piwik\Plugin\ViewDataTable;
use Piwik\Plugins\CoreVisualizations\Visualizations\HtmlTable;
use Piwik\Plugins\Referrers\Columns\Website;

class GetWebsites extends Base
{
    protected function init()
    {
        parent::init();
        $this->dimension     = new Website();
        $this->name          = Piwik::translate('CorePluginsAdmin_Websites');
        $this->documentation = Piwik::translate('Referrers_WebsitesReportDocumentation', '<br />');
        $this->actionToLoadSubTables = 'getUrlsFromWebsiteId';
        $this->order = 5;
        $this->widgetTitle  = 'Referrers_WidgetExternalWebsites';
    }

    public function configureView(ViewDataTable $view)
    {
        $view->config->subtable_controller_action  = 'getUrlsFromWebsiteId';
        $view->config->show_exclude_low_population = false;
        $view->config->show_goals = true;
        $view->config->addTranslation('label', Piwik::translate('Referrers_ColumnWebsite'));

        $view->requestConfig->filter_limit = 25;

        if ($view->isViewDataTableId(HtmlTable::ID)) {
            $view->config->disable_subtable_when_show_goals = true;
        }
    }

}