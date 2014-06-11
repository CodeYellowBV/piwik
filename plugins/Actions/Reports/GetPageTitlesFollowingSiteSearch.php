<?php
/**
 * Piwik - Open source web analytics
 *
 * @link http://piwik.org
 * @license http://www.gnu.org/licenses/gpl-3.0.html GPL v3 or later
 *
 */
namespace Piwik\Plugins\Actions\Reports;

use Piwik\Piwik;
use Piwik\Plugin\ViewDataTable;
use Piwik\Plugins\Actions\Columns\DestinationPage;

class GetPageTitlesFollowingSiteSearch extends SiteSearchBase
{
    protected function init()
    {
        parent::init();
        $this->dimension     = new DestinationPage();
        $this->name          = Piwik::translate('Actions_WidgetPageTitlesFollowingSearch');
        $this->documentation = Piwik::translate('Actions_SiteSearchFollowingPagesDoc') . '<br/>' . Piwik::translate('General_UsePlusMinusIconsDocumentation');
        $this->metrics       = array('nb_hits_following_search', 'nb_hits');
        $this->order = 19;
        $this->widgetTitle  = 'Actions_WidgetPageTitlesFollowingSearch';
    }

    public function configureView(ViewDataTable $view)
    {
        $title = Piwik::translate('Actions_WidgetPageUrlsFollowingSearch');

        $this->configureViewForUrlAndTitle($view, $title);
    }

    protected function configureViewForUrlAndTitle(ViewDataTable $view, $title)
    {
        $relatedReports = array(
            'Actions.getPageTitlesFollowingSiteSearch' => Piwik::translate('Actions_WidgetPageTitlesFollowingSearch'),
            'Actions.getPageUrlsFollowingSiteSearch'   => Piwik::translate('Actions_WidgetPageUrlsFollowingSearch'),
        );

        $view->config->addRelatedReports($relatedReports);
        $view->config->addTranslations(array(
            'label'                    => $this->dimension->getName(),
            'nb_hits_following_search' => Piwik::translate('General_ColumnViewedAfterSearch'),
            'nb_hits'                  => Piwik::translate('General_ColumnTotalPageviews')
        ));

        $view->config->title = $title;
        $view->config->columns_to_display          = array('label', 'nb_hits_following_search', 'nb_hits');
        $view->config->show_exclude_low_population = false;
        $view->requestConfig->filter_sort_column = 'nb_hits_following_search';
        $view->requestConfig->filter_sort_order  = 'desc';

        $this->addExcludeLowPopDisplayProperties($view);
        $this->addBaseDisplayProperties($view);
    }

}