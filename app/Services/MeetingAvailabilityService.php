<?php

namespace App\Services;

use App\Models\BuyerUserSchedule;
use App\Models\Event;
use App\Models\EventMeetingWindow;
use App\Models\Meeting;
use Carbon\Carbon;
use Illuminate\Support\Collection;

class MeetingAvailabilityService {
  public static function buyerHasAvailableHours(
    int $event_id,
    int $buyer_id,
    int $buyer_user_id
  ): bool {
    $event = Event::query()
      ->select(['id', 'meeting_time'])
      ->where('id', $event_id)
      ->where('is_active', true)
      ->first();

    if (!$event || !$event->meeting_time || $event->meeting_time <= 0) {
      return false;
    }

    $windows = BuyerUserSchedule::query()
      ->select([
        'presentation_date_id',
        'start_time',
        'end_time',
      ])
      ->where('is_active', true)
      ->where('event_id', $event_id)
      ->where('buyer_id', $buyer_id)
      ->where('buyer_user_id', $buyer_user_id)
      ->orderBy('presentation_date_id')
      ->orderBy('start_time')
      ->get();

    if ($windows->isEmpty()) {
      return false;
    }

    $busy_meetings = Meeting::query()
      ->select([
        'presentation_date_id',
        'start_time',
        'end_time',
      ])
      ->where('is_active', true)
      ->where('buyer_id', $buyer_id)
      ->where('buyer_user_id', $buyer_user_id)
      ->where(function ($query) {
        $query->whereNull('is_confirmed')
          ->orWhere('is_confirmed', true);
      })
      ->get();

    return self::hasAvailableHours(
      $windows,
      $busy_meetings,
      (int) $event->meeting_time
    );
  }

  public static function supplierHasAvailableHours(
    int $event_id,
    int $supplier_id,
    int $supplier_user_id
  ): bool {
    $event = Event::query()
      ->select(['id', 'meeting_time'])
      ->where('id', $event_id)
      ->where('is_active', true)
      ->first();

    if (!$event || !$event->meeting_time || $event->meeting_time <= 0) {
      return false;
    }

    $windows = EventMeetingWindow::query()
      ->select([
        'presentation_date_id',
        'start_time',
        'end_time',
      ])
      ->where('is_active', true)
      ->where('event_id', $event_id)
      ->orderBy('presentation_date_id')
      ->orderBy('start_time')
      ->get();

    if ($windows->isEmpty()) {
      return false;
    }

    $busy_meetings = Meeting::query()
      ->select([
        'presentation_date_id',
        'start_time',
        'end_time',
      ])
      ->where('is_active', true)
      ->where('supplier_id', $supplier_id)
      ->where('supplier_user_id', $supplier_user_id)
      ->where(function ($query) {
        $query->whereNull('is_confirmed')
          ->orWhere('is_confirmed', true);
      })
      ->get();

    return self::hasAvailableHours(
      $windows,
      $busy_meetings,
      (int) $event->meeting_time
    );
  }

  private static function hasAvailableHours(
    Collection $windows,
    Collection $busy_meetings,
    int $meeting_minutes
  ): bool {
    if ($meeting_minutes <= 0 || $windows->isEmpty()) {
      return false;
    }

    $busy_by_presentation_date = [];

    foreach ($busy_meetings as $meeting) {
      $busy_by_presentation_date[$meeting->presentation_date_id][] = [
        'start_time' => $meeting->start_time,
        'end_time' => $meeting->end_time,
      ];
    }

    foreach ($windows as $window) {
      $slot_start = Carbon::createFromFormat('H:i:s', $window->start_time);
      $window_end = Carbon::createFromFormat('H:i:s', $window->end_time);

      while (true) {
        $slot_end = (clone $slot_start)->addMinutes($meeting_minutes);

        if ($slot_end->gt($window_end)) {
          break;
        }

        $is_busy = false;
        $busy_ranges = $busy_by_presentation_date[$window->presentation_date_id] ?? [];

        foreach ($busy_ranges as $busy_range) {
          $busy_start = Carbon::createFromFormat('H:i:s', $busy_range['start_time']);
          $busy_end = Carbon::createFromFormat('H:i:s', $busy_range['end_time']);

          $overlaps = $slot_start->lt($busy_end) && $slot_end->gt($busy_start);

          if ($overlaps) {
            $is_busy = true;
            break;
          }
        }

        if (!$is_busy) {
          return true;
        }

        $slot_start = $slot_end;
      }
    }

    return false;
  }
}