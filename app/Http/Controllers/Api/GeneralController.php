<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Admin\Category;
use App\Models\Admin\Product;
use App\Models\Admin\ProductImage;
use Faker\Guesser\Name;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;

$id = 0;
class GeneralController extends Controller
{

    public function index()
    {
        $categories = Category::with('products')->with('childLevelCategories')->get();


        return response()->json($categories);
    }
    function storeCategory(Request $request){
        $arr = '[
	{
		"Title": "Normalab France-sas",
		"Products": [
			{
				"Title": "FLAMMABILITY",
				"Products": [
					{
						"Title": "CLOSED CUP",
						"Products": [
							{
								"Name": "NPM 450 - PMCC - Automated",
								"Image_URL": "http://ssscientific.net/assets/normalab/FLAMABIITY/CLOSED%20CUP/ASTM_D93_Pensky-Martens_Flash_point_NPM_450.png",
								"File_URL": "http://ssscientific.net/assets/normalab/FLAMABIITY/CLOSED%20CUP/D93_NPM%20450_60400_leaflet19.pdf"
							},
							{
								"Name": "NPV Tech - GO / NO GO - Automated",
								"Image_URL": "http://ssscientific.net/assets/normalab/FLAMABIITY/CLOSED%20CUP/ASTM_D3828_Flash-Point_NPV-Tech.png",
								"File_URL": "http://ssscientific.net/assets/normalab/FLAMABIITY/CLOSED%20CUP/D3828_NPV%20TECH_42000_Leaflet_EN-19_ld.pdf"
							},
							{
								"Name": "NAB 440 - Abel - Automated",
								"Image_URL": "http://ssscientific.net/assets/normalab/FLAMABIITY/CLOSED%20CUP/IP_170_Abel_Flash_Point_NAB_440.png",
								"File_URL": "http://ssscientific.net/assets/normalab/FLAMABIITY/CLOSED%20CUP/IP170_NAB%20440_41300_leaflet19.pdf"
							},
							{
								"Name": "NAB 110 - Abel - Manual",
								"Image_URL": "http://ssscientific.net/assets/normalab/FLAMABIITY/CLOSED%20CUP/IP_170_Flash-Point-Abel_NAB_110.png",
								"File_URL": "http://ssscientific.net/assets/normalab/FLAMABIITY/CLOSED%20CUP/IP170_NAB%20110_MANUAL_941601_lealfet15.pdf"
							},
							{
								"Name": "NPM 131 - PMCC - Manual",
								"Image_URL": "http://ssscientific.net/assets/normalab/FLAMABIITY/CLOSED%20CUP/ASTM_D93_Pensky-Martens_Flash_point_NPM_131.png",
								"File_URL": "http://ssscientific.net/assets/normalab/FLAMABIITY/CLOSED%20CUP/D93_NPM%20131_942616_leaflet-19.pdf"
							},
							{
								"Name": "NTA 440 - Tag - Automated",
								"Image_URL": "http://ssscientific.net/assets/normalab/FLAMABIITY/CLOSED%20CUP/ASTM_D56_Flash-point-TAG_NTA-440.png",
								"File_URL": "http://ssscientific.net/assets/normalab/FLAMABIITY/CLOSED%20CUP/D56_NTA%20440_40600_leaflet15%20rev1.pdf"
							},
							{
								"Name": "NAB TECH - Half Automated",
								"Image_URL": "http://ssscientific.net/assets/images/default.jpg",
								"File_URL": "http://ssscientific.net/assets/normalab/FLAMABIITY/CLOSED%20CUP/IP170_NAB%20TECH_42300-Leaflet-20.pdf"
							},
							{
								"Name": "NPM TECH - PMCC - Half Automated",
								"Image_URL": "http://ssscientific.net/assets/normalab/FLAMABIITY/CLOSED%20CUP/ASTM_D93_Pensky-Martens_Flash_point_NPM_231.png",
								"File_URL": "http://ssscientific.net/assets/normalab/FLAMABIITY/CLOSED%20CUP/D93_NPM%20231_942620_leaflet-19.pdf"
							},
							{
								"Name": "NPM TECH - PMCC",
								"Image_URL": "http://ssscientific.net/assets/normalab/FLAMABIITY/CLOSED%20CUP/ASTM_D93_Pensky-Martens_Flash_point_NPM_231.png",
								"File_URL": "http://ssscientific.net/assets/normalab/FLAMABIITY/CLOSED%20CUP/D93_NPM%20TECH_42100-Leaflet-20.pdf"
							}
						]
					},
					{
						"Title": "OPEN CUP",
						"Products": [
							{
								"Name": "NCL 120 - Clevelannd - Manual",
								"Image_URL": "http://ssscientific.net/assets/normalab/FLAMABIITY/OPEN%20CUP/ASTM_D92_Cleveland-Flash_point_NCL_120.png",
								"File_URL": "http://ssscientific.net/assets/normalab/FLAMABIITY/OPEN%20CUP/D92_NCL120_942611_leaflet-19.pdf"
							},
							{
								"Name": "NCL 440 - Cleveland - Automated",
								"Image_URL": "http://ssscientific.net/assets/normalab/FLAMABIITY/OPEN%20CUP/ASTM_D92_Cleveland-Flash_Point_NCL_440.png",
								"File_URL": "http://ssscientific.net/assets/normalab/FLAMABIITY/OPEN%20CUP/D92_NCL%20440_40400_leaflet19.pdf"
							}
						]
					}
				]
			},
			{
				"Title": "VOLATILITY",
				"Products": [
					{
						"Name": "CWB Classic - Reid Vapour Pressure",
						"Image_URL": "http://ssscientific.net/assets/normalab/VOLATILITY/ASTM_D323_Vapour_Pressure_Bath_CWB_Classic.png",
						"File_URL": "http://ssscientific.net/assets/normalab/VOLATILITY/D323_CWB_CLASSIC_941432_leaflet19.pdf"
					},
					{
						"Name": "NDI 450 - Atmospheric Distillation - Automated",
						"Image_URL": "http://ssscientific.net/assets/normalab/VOLATILITY/ASTM_D86_Distillation_NDI-450.png",
						"File_URL": "http://ssscientific.net/assets/normalab/VOLATILITY/D86_NDI450_60502_leaflet14_rev3.pdf"
					},
					{
						"Name": "NDI Classic - Atmospheric Distillation - Half Automated",
						"Image_URL": "http://ssscientific.net/assets/normalab/VOLATILITY/ASTM_D86_Distillation_NDI_Basic.png",
						"File_URL": "http://ssscientific.net/assets/normalab/VOLATILITY/D86_NDI_BASIC_941228_leaflet15%20rev1.pdf"
					},
					{
						"Name": "NDI Basic - Atmospheric Distillation - Manual",
						"Image_URL": "http://ssscientific.net/assets/normalab/VOLATILITY/ASTM_D86_Distillation_NDI_Classic.png",
						"File_URL": "http://ssscientific.net/assets/normalab/VOLATILITY/D86_NDI_CLASSIC_942228_leaflet15%20rev1.pdf"
					}
				]
			},
			{
				"Title": "CLOD FLOW PROPERTIES",
				"Products": [
					{
						"Name": "CPP Classic - Cloud and Pour Point - Cabinet",
						"Image_URL": "http://ssscientific.net/assets/normalab/COLD%20FLOW%20PROPERTIES/ASTM_D97_Cloud-and-Pour-Point_CPP_Classic.png",
						"File_URL": "http://ssscientific.net/assets/normalab/COLD%20FLOW%20PROPERTIES/D97_CPP%20CLASSIC_941592_leaflet18.pdf"
					}
				]
			},
			{
				"Title": "CLEANLINESS",
				"Products": [
					{
						"Title": "OXIDATION",
						"Products": [
							{
								"Name": "NGT Classic - Air / Steam Jet",
								"Image_URL": "http://ssscientific.net/assets/normalab/CLEANLINESS/OXIDATION/ASTM_D381_Existent-Gums_NGT_Classic.png",
								"File_URL": "http://ssscientific.net/assets/normalab/CLEANLINESS/OXIDATION/D381_NGT%20Classic_941320_Leaflet19.pdf"
							},
							{
								"Name": "NPI 442 - Induction Period and Potential Gums",
								"Image_URL": "http://ssscientific.net/assets/normalab/CLEANLINESS/OXIDATION/ASTM_D525_Oxidation-stability_NPI_442.png",
								"File_URL": "http://ssscientific.net/assets/normalab/CLEANLINESS/OXIDATION/D525_NPI%20442_40925_leaflet19.pdf"
							},
							{
								"Name": "TOST Classic - Oxidation Characteristics",
								"Image_URL": "http://ssscientific.net/assets/normalab/CLEANLINESS/OXIDATION/ASTM_D943_Oxidation_characteristics_TOST_Classic.png",
								"File_URL": "http://ssscientific.net/assets/normalab/CLEANLINESS/OXIDATION/D943_TOST%20CLASSIC_9416260_leaflet20.pdf"
							}
						]
					},
					{
						"Title": "FUEL CHARACTERISTICS",
						"Products": [
							{
								"Name": "NTB Classic - Copper Corrosion",
								"Image_URL": "http://ssscientific.net/assets/normalab/CLEANLINESS/FUEL%20CHARACTERISTICS/ASTM_D130_Copper-corrosion-detection_NTB%20Classic.png",
								"File_URL": "http://ssscientific.net/assets/normalab/CLEANLINESS/FUEL%20CHARACTERISTICS/D130_NTB%20CLASSIC_23007_leaflet15.pdf"
							},
							{
								"Name": "NAE 440 - Aniline Point - Automated",
								"Image_URL": "http://ssscientific.net/assets/normalab/CLEANLINESS/FUEL%20CHARACTERISTICS/ASTM_D611_aniline_point_NAE_440.png",
								"File_URL": "http://ssscientific.net/assets/normalab/CLEANLINESS/FUEL%20CHARACTERISTICS/D611_NAE%20440_40500_leaflet20.pdf"
							},
							{
								"Name": "NABLEND - Blender - Automated",
								"Image_URL": "http://ssscientific.net/assets/normalab/CLEANLINESS/FUEL%20CHARACTERISTICS/ASTM_D613_Blending-unit_NABLEND.png",
								"File_URL": "http://ssscientific.net/assets/normalab/CLEANLINESS/FUEL%20CHARACTERISTICS/D613%20NablendGB.PDF"
							}
						]
					},
					{
						"Title": "COLOUR",
						"Products": [
							{
								"Name": "AF 650 - ASTM Colour",
								"Image_URL": "http://ssscientific.net/assets/images/default.jpg",
								"File_URL": "http://ssscientific.net/assets/normalab/CLEANLINESS/COLOUR/D1500_AF%20650_24415_leaflet15.pdf"
							},
							{
								"Name": "SC Classic - Saybolt Chromometer",
								"Image_URL": "http://ssscientific.net/assets/normalab/CLEANLINESS/COLOUR/ASTM_D156_Saybolt_Chronometer_SC_Classic_941520.png",
								"File_URL": "http://ssscientific.net/assets/normalab/CLEANLINESS/COLOUR/D156_%20SC%20CLASSIC_941520_leaflet-19.pdf"
							}
						]
					},
					{
						"Title": "CARBON & SEDIMENT",
						"Products": [
							{
								"Name": "ARCOS",
								"Image_URL": "http://ssscientific.net/assets/images/spectro/Spectro%20Arcos.jpg",
								"File_URL": "http://ssscientific.net/assets/pdf/Spectro/ARCOS%20BROCHURE.pdf"
							},
							{
								"Name": "SPECTRO GENESIS",
								"Image_URL": "http://ssscientific.net/assets/images/spectro/Spectro%20Genesis.jpg",
								"File_URL": "http://ssscientific.net/assets/pdf/Spectro/SPECTRO%20GENESIS.pdf"
							},
							{
								"Name": "SPECTRO BLUE",
								"Image_URL": "http://ssscientific.net/assets/images/spectro/blue_315x220.png",
								"File_URL": "http://ssscientific.net/assets/pdf/Spectro/SPECTROBLUE%20BROCHURE.pdf"
							},
							{
								"Name": "SPECTRO GREEN",
								"Image_URL": "http://ssscientific.net/assets/images/spectro/Spectro%20Green.jpg",
								"File_URL": "http://ssscientific.net/assets/pdf/Spectro/SPECTROGREEN%20BROCHURE.pdf"
							}
						]
					}
				]
			},
			{
				"Title": "LUBRICANTS",
				"Products": [
					{
						"Name": "DEM Classic - Water / Oil Separator",
						"Image_URL": "http://ssscientific.net/assets/normalab/LUBRICANTS/ASTM_D1401_Oil-water_separation_DEM_Classic.png",
						"File_URL": "http://ssscientific.net/assets/normalab/LUBRICANTS/D1401_DEM%20CLASSIC_942525_leaflet-19.pdf"
					},
					{
						"Name": "ARV Tech - Air Release Value",
						"Image_URL": "http://ssscientific.net/assets/normalab/LUBRICANTS/ASTM_D3427_Air-release_Impinger_ARV_Tech.png",
						"File_URL": "http://ssscientific.net/assets/normalab/LUBRICANTS/D3427_ARVTECH_942900_Leaflet19.pdf"
					},
					{
						"Name": "FOAM2 Classic - Double Bath Version",
						"Image_URL": "http://ssscientific.net/assets/normalab/LUBRICANTS/ASTM_D892_Foaming_FOAM2_Classic.png",
						"File_URL": "http://ssscientific.net/assets/normalab/LUBRICANTS/D892_FOAM%20CLASSIC_941640_941643_leaflet15.pdf"
					},
					{
						"Name": "FOAM HT Classic - High Temperatures",
						"Image_URL": "http://ssscientific.net/assets/normalab/LUBRICANTS/ASTM_D892_Foaming_FOAM2_Classic.png",
						"File_URL": "http://ssscientific.net/assets/normalab/LUBRICANTS/D892_FOAM%20HT%20CLASSIC_9416432_leaflet15.pdf"
					}
				]
			},
			{
				"Title": "BITUMEN, WAXES & GREASE",
				"Products": [
					{
						"Name": "GWM Classic - Grease Worker - Automated",
						"Image_URL": "http://ssscientific.net/assets/normalab/BITUMEN,%20WAXES%20&%20GREASE/ASTM_D217_Grease_worker_Penetration_GWM_Classic.png",
						"File_URL": "http://ssscientific.net/assets/normalab/BITUMEN,%20WAXES%20&%20GREASE/D217_GWM_CLASSIC_9417582_leaflet-19.pdf"
					},
					{
						"Name": "RTFOT Classic - RTFOT Ageing Oven",
						"Image_URL": "http://ssscientific.net/assets/normalab/BITUMEN,%20WAXES%20&%20GREASE/ASTM_D2872_RTFOT_Classic_941877%20.png",
						"File_URL": "http://ssscientific.net/assets/normalab/BITUMEN,%20WAXES%20&%20GREASE/D2872_RTFOT_CLASSIC_941877_leaflet-20.pdf"
					},
					{
						"Name": "NBA Classic - Softening Point - Automated",
						"Image_URL": "http://ssscientific.net/assets/normalab/BITUMEN,%20WAXES%20&%20GREASE/ASTM_D36_Ring-and-ball_NBA_450.png",
						"File_URL": "http://ssscientific.net/assets/normalab/BITUMEN,%20WAXES%20&%20GREASE/D36_NBA%20450_60700-Leaflet19.pdf"
					},
					{
						"Name": "Penetrometer - Manual",
						"Image_URL": "http://ssscientific.net/assets/normalab/BITUMEN,%20WAXES%20&%20GREASE/ASTM_D36_Softening-Point-Ring&ball_20761.png",
						"File_URL": "http://ssscientific.net/assets/normalab/BITUMEN,%20WAXES%20&%20GREASE/D5_MANUAL%20PENETROMETER_%20941731_leaflet%2015.pdf"
					},
					{
						"Name": "NPN Tech - Penetrometer - Automated",
						"Image_URL": "http://ssscientific.net/assets/normalab/BITUMEN,%20WAXES%20&%20GREASE/ASTM_D5_Penetrometer_NPN_Tech.png",
						"File_URL": "http://ssscientific.net/assets/normalab/BITUMEN,%20WAXES%20&%20GREASE/D5_NPN%20TECH_942734-Leaflet19.pdf"
					}
				]
			},
			{
				"Title": "VISCOSITY",
				"Products": [
					{
						"Name": "CHRONOTECH - Automatic Chronometer",
						"Image_URL": "http://ssscientific.net/assets/normalab/VISCOSITY/ASTM_D445_Chronometer_ChronoTech.png",
						"File_URL": "http://ssscientific.net/#"
					},
					{
						"Name": "VTW Classic - Viscometer Washer - Automated",
						"Image_URL": "http://ssscientific.net/assets/normalab/VISCOSITY/ASTM_D445_tube_washer_VTW_Classic.png",
						"File_URL": "http://ssscientific.net/assets/normalab/VISCOSITY/D445_VTW%20CLASSIC_18450_leaflet15.pdf"
					},
					{
						"Name": "NVB Classic - Viscosity Bath",
						"Image_URL": "http://ssscientific.net/assets/normalab/VISCOSITY/ASTM_D445_Viscosity_Bath_NVB_Classic.png",
						"File_URL": "http://ssscientific.net/assets/normalab/VISCOSITY/D445_NVB%20CLASSIC_23207_leaflet15%20rev1.pdf"
					}
				]
			},
			{
				"Title": "GLLASSWARE",
				"Products": [
					{
						"Name": "Centrifuge glassware",
						"Image_URL": "http://ssscientific.net/assets/normalab/petri.png",
						"File_URL": "http://ssscientific.net/assets/normalab/GLASSWARE/Centrifuge%20glassware%20EN%20v.pdf"
					},
					{
						"Name": "Distillation glassware",
						"Image_URL": "http://ssscientific.net/assets/images/default.jpg",
						"File_URL": "http://ssscientific.net/assets/normalab/GLASSWARE/Distillation%20glassware%20EN%20v.pdf"
					},
					{
						"Name": "Houillon glassware",
						"Image_URL": "http://ssscientific.net/assets/images/default.jpg",
						"File_URL": "http://ssscientific.net/assets/normalab/GLASSWARE/Houillon%20glassware%20EN%20v.pdf"
					},
					{
						"Name": "Normalab Petroleum Glassware 2020HD",
						"Image_URL": "http://ssscientific.net/assets/normalab/HD.png",
						"File_URL": "http://ssscientific.net/assets/normalab/GLASSWARE/Normalab%20Petroleum%20Glassware%202020HD.pdf"
					}
				]
			},
			{
				"Title": "GENERAL CATELOG",
				"Products": [
					{
						"Name": "GENERAL CATELOG",
						"Image_URL": "",
						"File_URL": "http://ssscientific.net/assets/pdf/normal_lab.pdf"
					}
				]
			}
		]
	},
	{
		"Title": "Spectro, GmbH",
		"Products": [
			{
				"Title": "ICP-OES Spectrometers",
				"Products": [
					{
						"Name": "ARCOS",
						"Image_URL": "http://ssscientific.net/assets/images/spectro/Spectro%20Arcos.jpg",
						"File_URL": "http://ssscientific.net/assets/pdf/Spectro/ARCOS%20BROCHURE.pdf"
					},
					{
						"Name": "SPECTRO GENESIS",
						"Image_URL": "http://ssscientific.net/assets/images/spectro/Spectro%20Genesis.jpg",
						"File_URL": "http://ssscientific.net/assets/pdf/Spectro/SPECTRO%20GENESIS.pdf"
					},
					{
						"Name": "SPECTRO BLUE",
						"Image_URL": "http://ssscientific.net/assets/images/spectro/blue_315x220.png",
						"File_URL": "http://ssscientific.net/assets/pdf/Spectro/SPECTROBLUE%20BROCHURE.pdf"
					},
					{
						"Name": "SPECTRO GREEN",
						"Image_URL": "http://ssscientific.net/assets/images/spectro/Spectro%20Green.jpg",
						"File_URL": "http://ssscientific.net/assets/pdf/Spectro/SPECTROGREEN%20BROCHURE.pdf"
					}
				]
			},
			{
				"Title": "XRF Spectrometers",
				"Products": [
					{
						"Name": "SPECTRO CUBE",
						"Image_URL": "http://ssscientific.net/assets/images/spectro/Spectro%20Cube%20C.jpg",
						"File_URL": "http://ssscientific.net/assets/pdf/Spectro/SPECTRO%20CUBE%20BROCHURE.pdf"
					},
					{
						"Name": "SPECTRO XEPOS",
						"Image_URL": "http://ssscientific.net/assets/images/spectro/Spectro%20XEPOS.jpg",
						"File_URL": "http://ssscientific.net/assets/pdf/Spectro/SPECTRO%20XEPOS.pdf"
					}
				]
			},
			{
				"Title": "General Spectrometers",
				"Products": [
					{
						"Name": "GENERAL SPECTRO",
						"Image_URL": "http://ssscientific.net/assets/images/spectro_general.png",
						"File_URL": "http://ssscientific.net/assets/pdf/Spectro/GENERAL%20SPECTRO%20BROCHURE.pdf"
					}
				]
			}
		]
	},
	{
		"Title": "ECH, GmbH",
		"Products": [
			{
				"Title": "Karl Fischer Titrators",
				"Products": [
					{
						"Name": "Aquamax KF Plus",
						"Image_URL": "http://ssscientific.net/assets/images/ech/Karl-Fischer-Titrators/aquamax_150x200_rand.jpg",
						"File_URL": "http://ssscientific.net/assets/pdf/ECH/Karl-Fischer-Titrators/aquamax_kf_plus_engl.pdf"
					},
					{
						"Name": "Aquamax KF Portable",
						"Image_URL": "http://ssscientific.net/assets/images/ech/Karl-Fischer-Titrators/aquamax_portable_150x200_rand.jpg",
						"File_URL": "http://ssscientific.net/assets/pdf/ECH/Karl-Fischer-Titrators/aquamax_kf_portable_engl.pdf"
					},
					{
						"Name": "Aquamax KF PRO LPG",
						"Image_URL": "http://ssscientific.net/assets/images/ech/Karl-Fischer-Titrators/am_lpg_man_200x175.jpeg",
						"File_URL": "http://ssscientific.net/assets/pdf/ECH/Karl-Fischer-Titrators/aquamax_pro_lpg_engl.pdf"
					},
					{
						"Name": "Aquamax KF PRO Oil",
						"Image_URL": "http://ssscientific.net/assets/images/ech/Karl-Fischer-Titrators/am_pro_oil_woman_200x175.jpg",
						"File_URL": "http://ssscientific.net/assets/pdf/ECH/Karl-Fischer-Titrators/aquamax_pro_oil_engl.pdf"
					},
					{
						"Name": "AQUA 40.00 Basic Module",
						"Image_URL": "http://ssscientific.net/assets/images/ech/Karl-Fischer-Titrators/aqua_basic_module_150x225.jpg",
						"File_URL": "http://ssscientific.net/assets/pdf/ECH/Karl-Fischer-Titrators/aqua_40.00_engl.pdf"
					},
					{
						"Name": "AQUA 40.00 Vario Headspace",
						"Image_URL": "http://ssscientific.net/assets/images/ech/Karl-Fischer-Titrators/aqua_hs_vario_grey_72dpi_200x172.jpg",
						"File_URL": "http://ssscientific.net/assets/pdf/ECH/Karl-Fischer-Titrators/aqua_vario_headspace_module.pdf"
					},
					{
						"Name": "AQUA 40.00 with HT 1300",
						"Image_URL": "http://ssscientific.net/assets/images/ech/Karl-Fischer-Titrators/aqua_gm_ofen_200x146.jpg",
						"File_URL": "http://ssscientific.net/assets/pdf/ECH/Karl-Fischer-Titrators/aqua_high_temperature_oven.pdf"
					},
					{
						"Name": "OnlineH2O",
						"Image_URL": "http://ssscientific.net/assets/images/ech/Karl-Fischer-Titrators/onlineh2o_150x167.jpg",
						"File_URL": "http://ssscientific.net/assets/pdf/ECH/Karl-Fischer-Titrators/online_h2o_en.pdf"
					}
				]
			},
			{
				"Title": "H2S Analyzer",
				"Products": [
					{
						"Name": "H2S ANALYZER Lab",
						"Image_URL": "http://ssscientific.net/assets/images/ech/H2S-Analyzer/h2s_lab_blue_200x152.jpg",
						"File_URL": "http://ssscientific.net/assets/pdf/ECH/H2S-Analyzer/h2s_analyzer_lab_eng.pdf"
					},
					{
						"Name": "H2S ANALYZER Cubi",
						"Image_URL": "http://ssscientific.net/assets/images/ech/H2S-Analyzer/h2s_cubi_blue_200x191.jpeg",
						"File_URL": "http://ssscientific.net/assets/pdf/ECH/H2S-Analyzer/h2s_analyzer_cubi_eng.pdf"
					},
					{
						"Name": "Headspace Module",
						"Image_URL": "http://ssscientific.net/assets/images/ech/H2S-Analyzer/h2s_exths_72dpi_200x236.jpeg",
						"File_URL": "http://ssscientific.net/assets/pdf/ECH/H2S-Analyzer/h2s_headspace_module.pdf"
					}
				]
			},
			{
				"Title": "OnlineH2S",
				"Products": [
					{
						"Name": "Online H2S",
						"Image_URL": "http://ssscientific.net/assets/images/ech/online_h2s_gas_200x150.jpg",
						"File_URL": "http://ssscientific.net/assets/pdf/ECH/online_h2s_for_gases.pdf"
					}
				]
			},
			{
				"Title": "S-Online",
				"Products": [
					{
						"Name": "S Online",
						"Image_URL": "http://ssscientific.net/assets/images/ech/s_online_200x225.jpg",
						"File_URL": "http://ssscientific.net/assets/pdf/ECH/s_online_en.pdf"
					}
				]
			}
		]
	},
	{
		"Title": "Paragon Scientific, U.K.",
		"Products": [
			{
				"Name": "Paragon Scientific Ltd Products & Service",
				"Image_URL": "http://ssscientific.net/assets/images/paragon.png",
				"File_URL": "http://ssscientific.net/assets/pdf/Paragon/Paragon%20Scientific%20Ltd%20Products%20&%20Service%20Brochure%20(HR)%20v2.pdf"
			}
		]
	}
]';
        $cats  = json_decode($arr);
        $this->getCategory($cats);
//        dd();

    }

    function getCategory($cats, $parent_id = 0){
//        dd($cats);
    //        foreach($cats as $cat){
    //            if(isset($cat->Title)){
    //                echo "Cat ->".$cat->Title."<br />";
    ////                if(count($cat->Products) > 0){
    ////                    foreach($cat->Products as $child){
    ////                        echo "Cat ->".$child->Title."<br />";
    //////                        dd($child);
    //                        if(is_array($cat->Products)){
    //                            foreach($cat->Products as $child){
    //                                return $this->getCategory($child);
    //                            }
    //                        }else{
    //                            return $this->getCategory($cat->Products);
    //                        }
    ////                    }
    ////                }
    //            }
    //        }

        $catName = '';
        foreach ($cats as $cat) {
            if (isset($cat->Title)) {
//echo "Cat: " . $cat->Title. ' - id => ' .++$id . ' - P_id => ' .$parent_id . "<br>";
//                echo "INSERT INTO `categories` (`category_name`, `id_parent`, `status`) VALUES ('".$cat->Title."', NULL, '1');". "<br>";
            }

            if (isset($cat->Products)) {
                $this->getCategory($cat->Products);
            } else {
                echo ' -> '.$cat->Name." - ".' -> '.$this->slugify($cat->Name);
//                INSERT INTO `products` (`id`, `id_category`, `sr_no`, `pn_no`, `hsn_no`, `sku`, `name`, `slug`, `short_description`, `description`, `features`, `status`, `sale_price`, `is_featured`, `is_reusable`, `created_at`, `updated_at`) VALUES (NULL, '2', 'SLL-1', 'PN1-1', 'HSN1-1', 'PSK', 'PP TEWS', 'pp-tews', 'adsaf', 'fadfdaf', '1', '1', '5000', '1', '0', NULL, NULL)
                $productDet = Product::where("name",'like',"%".$cat->Name."%")->get()->first();
                if($productDet){
                    $cat->Name = $cat->Name.'_'.$productDet->id;
                }
                $product = new Product();
                $product->id_category = 1;
                $product->name = $cat->Name;
                $product->slug = $this->slugify($cat->Name);
                $product->short_description = 'Short Desciption ';
                $product->description = 'Description';
                $product->sale_price = rand(5000,15000);
                $product->status = 1;
                $product->sku = "SSS_";
                $product->save();

                if($product){
                    $product->sku = "SSS_".$product->id;
                    $product->sr_no = $product->id;
                    $product->pn_no = "PN_NO".$product->id;
                    $product->hsn_no = "HSN_NO".$product->id;;
                    $product->save();
                }
            }
        }
    }

    function slugify($string) {
        $string = trim($string);
        $string = strtolower($string);
        $string = preg_replace('/\s+/', '-', $string);
        $string = preg_replace('/[^\w\-]+/', '', $string);
        $string = preg_replace('/\-+/', '-', $string);
        $string = preg_replace('/^-+/', '', $string);
        $string = preg_replace('/-+$/', '', $string);

        return $string;
    }

    function updateExistingProductInfo(){
        $path = public_path('ss_products.json');

        // Check if the file exists
        if (!File::exists($path)) {
            return response()->json(['error' => 'File not found'], 404);
        }

        // Get the file contents
        $json = File::get($path);

        // Decode the JSON data
        $data = json_decode($json, true);

        foreach($data as $key => $product){
            $productDb = Product::where(['name' => $product['Name']])->get()->first();
            if($productDb) {
                if(isset($product['Image_URL']) && !empty($product['Image_URL'])){
                    $productDocument =new ProductImage();
                    $productDocument->id_product = $productDb->id;
                    $productDocument->image_name = $product['Image_URL'];
                    $productDocument->type = 0;
                    $productDocument->save();
                }
                if(isset($product['File_URL']) && !empty($product['File_URL'])){
                    $productDocument =new ProductImage();
                    $productDocument->id_product = $productDb->id;
                    $productDocument->image_name = $product['File_URL'];
                    $productDocument->type = 1;
                    $productDocument->save();
                }
            }
        }

        // Return the manipulated data as a response
        return response()->json(['messages' => 'data sync']);

    }
}


