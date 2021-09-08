class MultiFilters {

	constructor(items, search, filter, filter_items) {
		this.items = items;
		this.search = search;
		this.filter = filter;
		this.filter_items = filter_items;
	}

	is_valid_value = (item) => {
		if (typeof item === 'undefined' || item === null || item == '' && item.replace(/ /g, '') == '')
			return false;
		return true;
	}

	static is_valid_value = (item) => {
		if (typeof item === 'undefined' || item === null || item == '' && item.replace(/ /g, '') == '')
			return false;
		return true;
	}
	string_cleaner = (item) => {
		if (this.is_valid_value(item))
			return item.toString().toLowerCase().replace(/\s+/g, ' ').trim();
		return "";
	}

	// For numbers ================================================
	custom_filter_numbers = ({
		item,
		all_filters,
		filter,
		item_value,
		filter_item,
		filter_value
	}) => {
		const inherited = item.inherit_value;
		if ('inherit_value' in item && all_filters[inherited + "_selection"].value == 'range') {
			const min = all_filters[inherited + "_min"].value;
			const max = all_filters[inherited + "_max"].value;
			const value = filter[inherited];
			if (!isNaN(value) && this.is_valid_value(value) &&
				this.is_valid_value(min) && this.is_valid_value(max) &&
				!isNaN(min) && !isNaN(max)) {
				const min_value = parseFloat(min);
				const max_value = parseFloat(max);
				const filter_value_num = parseFloat(filter[inherited]);
				if (filter_value_num < min_value || filter_value_num > max_value) {
					return false;
				}
			}
		} else if (!('inherit_value' in item) && !isNaN(item_value)) {
			const selection_value = all_filters[filter_item + "_selection"].value;
			if (selection_value != 'range' && !isNaN(filter_value) && this.is_valid_value(filter_value)) {
				const value = parseFloat(item_value);
				const filter_value_num = parseFloat(filter_value);
				if (selection_value == '==') {
					if (!(filter_value_num == value)) return false;
				} else if (selection_value == '>=') {
					if (!(filter_value_num >= value)) return false;
				} else if (selection_value == '<=') {
					if (!(filter_value_num <= value)) return false;
				} else if (selection_value == '>') {
					if (!(filter_value_num > value)) return false;
				} else if (selection_value == '<') {
					if (!(filter_value_num < value)) return false;
				}
			}
		}
		return true;
	}

	custom_filter_string = ({
		item,
		all_filters,
		filter,
		item_value,
		filter_item,
		filter_value
	}) => {
		
		const value = this.string_cleaner(item_value);
		const filter_value_num = this.string_cleaner(filter_value);
		if (this.is_valid_value(value) && this.is_valid_value(filter_value_num)) {
			if ('multiple_selection' in item) {
				if (value !== filter_value_num) return false;
			} else if( 'specific' in item && item.specific ){
				if( filter_value_num != value) return false;
			} else {
				if (!filter_value_num.includes(value)) return false;
			}
		}
		
		return true;
	}
	custom_filter_date = ({ item, all_filters, filter, item_value, filter_item, filter_value }) =>{
		const value  = new Date(item_value).getTime();
		const filter_value_num =  new Date(filter_value).getTime();

		const inherited = item.inherit_value;
	
		if ('inherit_value' in item && all_filters[inherited + "_selection"].value == 'range') {
			
		}
		return true;
	}
	custom_filter = () => {
		const all_filters = this.filter_items;
		const items = this.items;
		const search = this.search;
		const filter = this.filter;
		console.log("hello world")
		for (const filter_item in all_filters) {
			const item = all_filters[filter_item];
			const item_value = item.value;
			
			if (this.is_valid_value(item_value)) {
				const filter_value = filter[filter_item];

				if (!this.is_valid_value(filter_value) && !('inherit_value' in item)) continue;

				if ('date_range' in item && item.date_range){
					if (!this.custom_filter_date({
						item,
						all_filters,
						filter,
						item_value,
						filter_item,
						filter_value
					}))
					return false;
				}else if ('number_range' in item && item.number_range) {
					if (!this.custom_filter_numbers({
							item,
							all_filters,
							filter,
							item_value,
							filter_item,
							filter_value
						}))
						return false;
				} else {
					if (!this.custom_filter_string({
							item,
							all_filters,
							filter,
							item_value,
							filter_item,
							filter_value
						}))
						return false;
				}
			}
		}
		return true;
	}

	static changeFilterActiveValue(key, filter, active_key, active_value) {
		if (this.is_valid_value(key) && !this.is_valid_value(active_value))
			for (const item in filter)
				if (this.is_valid_value(item) && item != key && 'value' in filter[item] && this.is_valid_value(filter[item].value))
					return item;
		return key;
	}

}




// Vue plugin.
const MultiFiltersPlugin = {
	install(Vue, options) {
		Vue.prototype.$MultiFilters = MultiFilters;
	}
};

export default MultiFiltersPlugin;