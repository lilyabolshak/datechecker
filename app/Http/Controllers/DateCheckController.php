<?php

namespace App\Http\Controllers;

use App\Http\Requests\DateCheckRequest;
use App\Services\DateManagement;
use App\Services\HolidayStatisticManagement;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class DateCheckController extends Controller
{
    /**
     * @param HolidayStatisticManagement $holidayStatisticManagement
     * @param DateManagement $dateManagement
     */
    public function __construct(
        public HolidayStatisticManagement $holidayStatisticManagement,
        public DateManagement $dateManagement
    ) {
        //
    }

    /**
     * @return View
     */
    public function index(): View
    {
        return view('date-check-form');
    }

    /**
     * @param DateCheckRequest $request
     * @return RedirectResponse
     */
    public function store(DateCheckRequest $request): RedirectResponse
    {
        $request->validate(['date' => 'date']);

        $date = $request->input('date');
        $message = 'This is not a holiday!';
        $dateObject = \DateTime::createFromFormat('U', strtotime($date));
        if ($this->dateManagement->isHoliday($dateObject)) {
            $message = __(sprintf('It’s %s on that date!', $this->dateManagement->getHolidayName()));
            $this->holidayStatisticManagement->addStatistic($dateObject->format('Y-m-d'));
        }

        return redirect()->route('date-check')
            ->with('message', $message);
    }
}
