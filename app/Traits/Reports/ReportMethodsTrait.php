<?php

namespace App\Traits\Reports;

trait ReportMethodsTrait
{
  /**
   * Filters data based on the provided type.
   *
   * @param string $typeFilterBy The type of filter to apply (e.g. 'today', 'yesterday', 'last_week', etc.)
   * @return array An array containing the start and end dates for the filtered data
   */
  protected function filterDataBy($typeFilterBy)
  {
    $filterDate = match ($typeFilterBy) {
      'today' => [now()->startOfDay(), now()->endOfDay()],
      'yesterday' => [now()->subDay()->startOfDay(), now()->subDay()->endOfDay()],
      'last_week' => [now()->subDays(7)->startOfDay(), now()->endOfDay()],
      'last_month' => [now()->subMonth()->startOfMonth(), now()->subMonth()->endOfMonth()],
      'this_year' => [now()->startOfYear(), now()->endOfYear()],
      'last_year' => [now()->subYear()->startOfYear(), now()->subYear()->endOfYear()],
      default => [now()->startOfYear(), now()->endOfYear()],
    };
    return $filterDate;
  }
}
