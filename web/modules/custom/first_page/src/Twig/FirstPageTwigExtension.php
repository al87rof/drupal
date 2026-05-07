<?php

namespace Drupal\first_page\Twig;

use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

class FirstPageTwigExtension  extends AbstractExtension {

  /**
   * {@inheritdoc}
   */
  public function getFunctions(): array {
    return [
      new TwigFunction('my_date_function', [$this, 'getCurrentDate']),
    ];
  }


  public function getCurrentDate(): string {
    $config = \Drupal::config('system.site');
    $site_name = $config->get('name');

    $current_date = new \DateTime();
    $formatted_date = $current_date->format('d.m.Y H:i');

    return $site_name . ' - ' . $formatted_date;
  }

}
