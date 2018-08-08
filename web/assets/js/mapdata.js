var map_const = {
    inactive_color: "#DADADA",
    active_color: "#FFB452"
};

var simplemaps_continentmap_mapdata={
  main_settings: {
    //General settings
		width: 'responsive',
    background_color: "#FFFFFF",
    background_transparent: "yes",
    border_color: "#ffffff",
    popups: "detect",
    
		//State defaults
		state_description: "",
    state_color: "#DADADA",
    state_hover_color: "#FFB452",
    state_url: "?order=NONE",
    border_size: 1.5,
    all_states_inactive: "no",
    all_states_zoomable: "no",
    
		//Location defaults
		location_description: "Location description",
    location_color: "#FF0067",
    location_opacity: 0.8,
    location_hover_opacity: 1,
    location_url: "",
    location_size: 25,
    location_type: "square",
    location_image_source: "frog.png",
    location_border_color: "#FFFFFF",
    location_border: 2,
    location_hover_border: 2.5,
    all_locations_inactive: "no",
    all_locations_hidden: "no",
    
		//Label defaults
		label_color: "#000000",
    label_hover_color: "#000000",
    label_size: 25,
    label_font: "Arial",
    hide_labels: "no",
   
		//Zoom settings
		manual_zoom: "no",
    back_image: "no",
    arrow_color: "#cecece",
    arrow_color_border: "#808080",
    initial_back: "no",
    initial_zoom: -1,
    initial_zoom_solo: "no",
    region_opacity: 1,
    region_hover_opacity: 0.6,
    zoom_out_incrementally: "yes",
    zoom_percentage: 0.99,
    zoom_time: 0.5,
    
		//Popup settings
		popup_color: "white",
    popup_opacity: 0.9,
    popup_shadow: 1,
    popup_corners: 5,
    popup_font: "12px/1.5 Verdana, Arial, Helvetica, sans-serif",
    popup_nocss: "no",
    
		//Advanced settings
		div: "map",
    auto_load: "yes",
    url_new_tab: "no",
    images_directory: "default",
    fade_time: 0.1,
    link_text: "(View Link)"
  },
  state_specific: {
    SA: {
      name: "남아메리카",
      description: "default",
      color: "#DADADA",
      hover_color: "#FFB452",
      url: "?state=SA"
    },
    NA: {
      name: "북아메리카",
      description: "default",
      color: "#DADADA",
      hover_color: "#FFB452",
      url: "?state=NA"
    },
    EU: {
      name: "유럽",
      description: "default",
      color: "#DADADA",
      hover_color: "#FFB452",
      url: "?state=EU"
    },
    AF: {
      name: "아프리카",
      description: "default",
      color: "#DADADA",
      hover_color: "#FFB452",
      url: "?state=AF"
    },
    NS: {
      name: "북아시아",
      description: "default",
      color: "#DADADA",
      hover_color: "#FFB452",
      url: "?state=NS"
    },
    SS: {
      name: "남아시아",
      description: "default",
      color: "#DADADA",
      hover_color: "#FFB452",
      url: "?state=SS"
    },
    ME: {
      name: "중동아시아",
      description: "default",
      color: "#DADADA",
      hover_color: "#FFB452",
      url: "?state=ME"
    },
    OC: {
      name: "오세아니아",
      description: "default",
      color: "#DADADA",
      hover_color: "#FFB452",
      url: "?state=OC"
    }
  },
  locations: {
    // "0": {
    //   name: "New York",
    //   lat: 40.71,
    //   lng: -74.0059731,
    //   description: "default",
    //   color: "default",
    //   url: "default",
    //   size: "default"
    // },
    // "1": {
    //   name: "London",
    //   lat: 51.5073346,
    //   lng: -0.1276831,
    //   description: "default",
    //   color: "default",
    //   url: "default"
    // }
  },
  labels: {
    "0": {
      name: "남아메리카",
      x: 850.4,
      y: 873.8,
      parent_id: "SA"
    },
    "1": {
      name: "북아메리카",
      x: 570.4,
      y: 373.8,
      parent_id: "NA"
    },
    "2": {
      name: "유럽",
      x: 1400.5,
      y: 351.3,
      parent_id: "EU"
    },
    "3": {
      name: "아프리카",
      x: 1400.5,
      y: 661.3,
      parent_id: "AF"
    },
    "4": {
      name: "북아시아",
      x: 1800.5,
      y: 270,
      parent_id: "NS"
    },
    "5": {
      name: "남아시아",
      x: 1970,
      y: 480.7,
      parent_id: "SS"
    },
    "6": {
      name: "중동아시아",
      x: 1664.5,
      y: 503.9,
      parent_id: "ME"
    },
    "7": {
      name: "오세아니아",
      x: 2270.5,
      y: 980.2,
      parent_id: "OC"
    }
  }
};
