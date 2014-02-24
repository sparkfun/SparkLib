<?php
namespace Sparklib;

class NcursesProgressDialog {

  private $limit;

  // Middle window resource.
  private $window;

  // Position of the progress bar.
  private $bar_x = 1;

  /**
   * @param int $limit - the number of tasks to be completed, num db rows or whatever
   * @param string $title - the title of the window
   */
  public function __construct ($limit, $title='New Task')
  {
    // Fallback for if libncurses is missing.  Just do nothing.
    if (! function_exists('ncurses_init')) return;

    // How many records will we be processing?
    $this->limit = $limit;

    ncurses_init();

    // Border the screen.
    ncurses_border(0,0, 0,0, 0,0, 0,0);

    // Get the size of the screen.
    ncurses_getmaxyx(STDSCR, $lines, $columns);

    // Make a window in the middle that's half the width of the screen.
    $width = $columns / 2;
    $this->window = ncurses_newwin(15, $width, $lines/4, $width/2);
    ncurses_wborder($this->window, 0,0, 0,0, 0,0, 0,0);

    // Title it.
    ncurses_mvwaddstr($this->window, 0, 5, $title);

    // Show progress bar boundaries.
    ncurses_mvwaddstr($this->window, 12, 1, '|');
    ncurses_mvwaddstr($this->window, 12, $width-2, '|');

    // Figure out what one character is worth based on the above.
    $this->unit = round($limit / ($width - 3));

    ncurses_refresh();
  }

  /**
   * @param int $place - number of the current task
   */
  public function update ($place)
  {
    if (! function_exists('ncurses_init')) return;

    ncurses_mvwaddstr($this->window, 5, 5, 'Processing record '.$place.' of '.$this->limit);

    $percent = (round($place / $this->limit, 2) * 100) . '%';
    ncurses_mvwaddstr($this->window, 10, 5, $percent);

    if ($place % $this->unit == 0) {
      $this->bar_x += 1;
      ncurses_mvwaddstr($this->window, 12, $this->bar_x, '=>');
    }

    ncurses_wrefresh($this->window);

    if ($place >= $this->limit) ncurses_end();
  }

  public function __destruct ()
  {
    if (! ncurses_isendwin()) {
      ncurses_end();
    }
  }

}
