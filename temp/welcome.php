<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Welcome extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->helper('url');
		$this->load->helper('form');
		$this->load->library('session');

		// Your own constructor code
	}
	
	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -  
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in 
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see http://codeigniter.com/user_guide/general/urls.html
	 */
	public function index()
	{
		
		
		$data['documentDirection'] = "rtl";
		$data['title'] = "taxiMeter";
		$data['startAddressLabel']= "כתובת התחלה";
		$data['destinationAddressLabel']= "כתובת יעד";
		$data['heading'] = "מונה או קבוע?";
		$data['howMuchButtonLabel'] = "אז כמה יעלה?";
		$data['siteDescription'] = "תיאור האתר";
		$data['advancedDetailsLabel'] = "פרטים נוספים";
		$data['moreThanTwoLabel'] = "יותר מ2  אנשים";
		$data['currentLocationLabel'] = "מיקום נוכחי";
		
		//Forms fields								
		//Exisiting event
		$this->load->view('welcome',$data);
		
	}
	
	public function calculateFare()
	{
		$data['duration'] = $_POST['duration'];
		$data['distance'] = $_POST['distance'];
		$data['fare'] = $_POST['duration'] + $_POST['distance']; 
		$encoded = json_encode($data);
		die($encoded);
	}
	
	public function _fareDetails()
	{
		//Initial price
		$InitailPrice = 11.8;
		$InitialPriceEilat = 10.1;
		$meterStep = 0.30;
		
		
		//if more then 2 passengers
		// + 4.70 nis
		
		//Rates
		//Rate1 = 5:30 - 21:00
		//Rate2 = 21:01 - 5:29 -> this is faster the rate1 and 25% more expensive
		
		//Call for taxi = 5nis
		
		//Luguage 
		// 4.2 each suitcase
		//Passengers
		//
	}
	
	
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */