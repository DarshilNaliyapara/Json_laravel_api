{
    "title": "Items",
        "type": "object",
            "properties": {
        "category": {
            "type": "object",
                "properties": {
                "flexibles": {
                    "type": "object",
                        "properties": {
                        "product": {
                            "type": "array",
                                "items": {
                                "title": "Product",
                                    "type": "object",
                                        "properties": {
                                    "product_name": {
                                        "title": "Name",
                                            "type": "string"
                                    },
                                    "varient_category": {
                                        "title": "Varient Category",
                                            "type": "array",
                                                "items": {
                                            "title": "Varient Category",
                                                "type": "object",
                                                    "properties": {
                                                "varient_category_name": {
                                                    "title": "Varient Category",
                                                        "type": "string"
                                                },
                                                "varients": {
                                                    "type": "array",
                                                        "items": {
                                                        "title": "Varient Name",
                                                            "type": "object",
                                                                "properties": {
                                                            "varient_name": {
                                                                "title": "Varient",
                                                                    "type": "string"
                                                            },
                                                            "type": {
                                                                "title": "Type",
                                                                    "type": "string",
                                                                        "default": "checkbox",
                                                                            "enum": [
                                                                                "dropdown(multiselect)",
                                                                                "checkbox",
                                                                                "text",
                                                                                "dropdown(singleselect)"
                                                                            ],
                                                                                "if": { "title": "Type" }, "then": { "title": "text" },
                                                                "options": {
                                                                    "enum_titles": [
                                                                        "Multiselect Dropdown",
                                                                        "Checkbox",
                                                                        "Textbox",
                                                                        "Single Select Dropdown"
                                                                    ]
                                                                }
                                                            },

                                                            "default": {
                                                                "title": "Default",
                                                                    "type": "string"
                                                            },
                                                            "width": {
                                                                "title": "Width",
                                                                    "type": "string"
                                                            }
                                                        }
                                                    }


                                                }
                                            }
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }
    }
}
    