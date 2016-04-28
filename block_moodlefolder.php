<?php
class block_moodlefolder extends block_base {
    public function init() {
        $this->title = get_string('moodlefolder', 'block_moodlefolder');
    }
    // The PHP tag and the curly bracket for the class definition
    // will only be closed after there is another function added in the next section.
    public function get_content() {

    	if ($this->content !== null) {
    		return $this->content;
    	}

    	global $DB, $COURSE, $USER, $PAGE;

    	$this->content = new StdClass();
    	$PAGE->requires->js_call_amd('block_moodlefolder/moodlefolder', 'init');
	    $subscribed = $DB->get_records('moodlefolder', array('username' => $USER->username, 'courseid' => $COURSE->id));
	    if (count($subscribed) != 0) {
	    	$this->content->text = html_writer::tag('button', "Unsubscribe", array('type' => 'submit', 'class' => 'block_moodlefolder_unsubscribe', 'id' => 'moodlefolder_button'));
	    } else {
	    	$this->content->text = html_writer::tag('button', "Subscribe", array('type' => 'submit', 'class' => 'block_moodlefolder_subscribe', 'id' => 'moodlefolder_button'));
	    }
	    return $this->content;
  	}
    public function has_config() {
        return true;
    }
}   // Here's the closing bracket for the class definition
