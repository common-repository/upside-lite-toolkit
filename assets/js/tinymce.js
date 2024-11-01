(function() {
  return tinymce.PluginManager.add("upside_shortcodes", function(editor) {
      var grid;
      grid = new Array(12);
      grid[0] = "[upside_col size=12]TEXT[/upside_col]<br/>";
      grid[1] = "[upside_col size=6]TEXT[/upside_col]<br/>";
      grid[1] += "[upside_col size=6]TEXT[/upside_col]<br/>";
      grid[2] = "[upside_col size=4]TEXT[/upside_col]<br/>";
      grid[2] += "[upside_col size=4]TEXT[/upside_col]<br/>";
      grid[2] += "[upside_col size=4]TEXT[/upside_col]<br/>";
      grid[3] = "[upside_col size=4]TEXT[/upside_col]<br/>";
      grid[3] += "[upside_col size=8]TEXT[/upside_col]<br/>";
      grid[4] = "[upside_col size=3]TEXT[/upside_col]<br/>";
      grid[4] += "[upside_col size=6]TEXT[/upside_col]<br/>";
      grid[4] += "[upside_col size=3]TEXT[/upside_col]<br/>";
      grid[5] = "[upside_col size=3]TEXT[/upside_col]<br/>";
      grid[5] += "[upside_col size=3]TEXT[/upside_col]<br/>";
      grid[5] += "[upside_col size=3]TEXT[/upside_col]<br/>";
      grid[5] += "[upside_col size=3]TEXT[/upside_col]<br/>";
      grid[6] = "[upside_col size=3]TEXT[/upside_col]<br/>";
      grid[6] += "[upside_col size=9]TEXT[/upside_col]<br/>";
      grid[7] = "[upside_col size=2]TEXT[/upside_col]<br/>";
      grid[7] += "[upside_col size=8]TEXT[/upside_col]<br/>";
      grid[7] += "[upside_col size=2]TEXT[/upside_col]<br/>";
      grid[8] = "[upside_col size=2]TEXT[/upside_col]<br/>";
      grid[8] += "[upside_col size=2]TEXT[/upside_col]<br/>";
      grid[8] += "[upside_col size=2]TEXT[/upside_col]<br/>";
      grid[8] += "[upside_col size=6]TEXT[/upside_col]<br/>";
      grid[9] = "[upside_col size=2]TEXT[/upside_col]<br/>";
      grid[9] += "[upside_col size=2]TEXT[/upside_col]<br/>";
      grid[9] += "[upside_col size=2]TEXT[/upside_col]<br/>";
      grid[9] += "[upside_col size=2]TEXT[/upside_col]<br/>";
      grid[9] += "[upside_col size=2]TEXT[/upside_col]<br/>";
      grid[9] += "[upside_col size=2]TEXT[/upside_col]<br/>";
      grid[10] = "[upside_col size=8]TEXT[/upside_col]<br/>";
      grid[10] += "[upside_col size=4]TEXT[/upside_col]<br/>";
      grid[11] = "[upside_col size=10]TEXT[/upside_col]<br/>";
      grid[11] += "[upside_col size=2]TEXT[/upside_col]<br/>";
    return editor.addButton("upside_shortcodes", {
      type: "splitbutton",
      title: upside_toolkit.i18n.shortcodes,
      icon: "upside_shortcodes",
      menu: [
          {
              text: upside_toolkit.i18n.grid,
              menu: [
                  {
                      text: "1/1",
                      onclick: function() {
                          var shortcode;
                          shortcode = "[upside_row]<br/>" + grid[0] + "[/upside_row]<br/>";
                          return tinyMCE.activeEditor.execCommand("mceInsertContent", 0, shortcode);
                      }
                  }, {
                      text: "1/2 - 1/2",
                      onclick: function() {
                          var shortcode;
                          shortcode = "[upside_row]<br/>" + grid[1] + "[/upside_row]<br/>";
                          return tinyMCE.activeEditor.execCommand("mceInsertContent", 0, shortcode);
                      }
                  }, {
                      text: "1/3 - 1/3 - 1/3",
                      onclick: function() {
                          var shortcode;
                          shortcode = "[upside_row]<br/>" + grid[2] + "[/upside_row]<br/>";
                          return tinyMCE.activeEditor.execCommand("mceInsertContent", 0, shortcode);
                      }
                  }, {
                      text: "1/3 - 2/3",
                      onclick: function() {
                          var shortcode;
                          shortcode = "[upside_row]<br/>" + grid[3] + "[/upside_row]<br/>";
                          return tinyMCE.activeEditor.execCommand("mceInsertContent", 0, shortcode);
                      }
                  }, {
                      text: "1/4 - 1/2 - 1/4",
                      onclick: function() {
                          var shortcode;
                          shortcode = "[upside_row]<br/>" + grid[4] + "[/upside_row]<br/>";
                          return tinyMCE.activeEditor.execCommand("mceInsertContent", 0, shortcode);
                      }
                  }, {
                      text: "1/4 - 1/4 - 1/4 - 1/4",
                      onclick: function() {
                          var shortcode;
                          shortcode = "[upside_row]<br/>" + grid[5] + "[/upside_row]<br/>";
                          return tinyMCE.activeEditor.execCommand("mceInsertContent", 0, shortcode);
                      }
                  }, {
                      text: "1/4 - 3/4",
                      onclick: function() {
                          var shortcode;
                          shortcode = "[upside_row]<br/>" + grid[6] + "[/upside_row]<br/>";
                          return tinyMCE.activeEditor.execCommand("mceInsertContent", 0, shortcode);
                      }
                  }, {
                      text: "1/6 - 4/6 - 1/6",
                      onclick: function() {
                          var shortcode;
                          shortcode = "[upside_row]<br/>" + grid[7] + "[/upside_row]<br/>";
                          return tinyMCE.activeEditor.execCommand("mceInsertContent", 0, shortcode);
                      }
                  }, {
                      text: "1/6 - 1/6 - 1/6 - 1/2",
                      onclick: function() {
                          var shortcode;
                          shortcode = "[upside_row]<br/>" + grid[8] + "[/upside_row]<br/>";
                          return tinyMCE.activeEditor.execCommand("mceInsertContent", 0, shortcode);
                      }
                  }, {
                      text: "1/6 - 1/6 - 1/6 - 1/6 - 1/6 - 1/6",
                      onclick: function() {
                          var shortcode;
                          shortcode = "[upside_row]<br/>" + grid[9] + "[/upside_row]<br/>";
                          return tinyMCE.activeEditor.execCommand("mceInsertContent", 0, shortcode);
                      }
                  }, {
                      text: "2/3 - 1/3",
                      onclick: function() {
                          var shortcode;
                          shortcode = "[upside_row]<br/>" + grid[10] + "[/upside_row]<br/>";
                          return tinyMCE.activeEditor.execCommand("mceInsertContent", 0, shortcode);
                      }
                  }, {
                      text: "5/6 - 1/6",
                      onclick: function() {
                          var shortcode;
                          shortcode = "[upside_row]<br/>" + grid[11] + "[/upside_row]<br/>";
                          return tinyMCE.activeEditor.execCommand("mceInsertContent", 0, shortcode);
                      }
                  }
              ]
          },
         {
          text: upside_toolkit.i18n.container,
          menu: [
              {
                  text: upside_toolkit.i18n.u_list,
                  menu: [
                      {
                          text: upside_toolkit.i18n.u_list_square,
                          onclick: function() {
                              var shortcode;
                              shortcode = "[upside_ulists type=\"square\"]<br/>";
                              shortcode += "[upside_ulist]List item[/upside_ulist]<br/>";
                              shortcode += "[upside_ulist]List item[/upside_ulist]<br/>";
                              shortcode += "[upside_ulist]List item[/upside_ulist]<br/>";
                              shortcode += "[/upside_ulists]<br/>";
                              return tinyMCE.activeEditor.execCommand("mceInsertContent", 0, shortcode);
                          }
                      },
                      {
                          text: upside_toolkit.i18n.u_list_round,
                          onclick: function() {
                              var shortcode;
                              shortcode = "[upside_ulists type=\"round\"]<br/>";
                              shortcode += "[upside_ulist]List item[/upside_ulist]<br/>";
                              shortcode += "[upside_ulist]List item[/upside_ulist]<br/>";
                              shortcode += "[upside_ulist]List item[/upside_ulist]<br/>";
                              shortcode += "[/upside_ulists]<br/>";
                              return tinyMCE.activeEditor.execCommand("mceInsertContent", 0, shortcode);
                          }
                      },
                      {
                          text: upside_toolkit.i18n.u_list_plus,
                          onclick: function() {
                              var shortcode;
                              shortcode = "[upside_ulists type=\"plus\"]<br/>";
                              shortcode += "[upside_ulist]List item[/upside_ulist]<br/>";
                              shortcode += "[upside_ulist]List item[/upside_ulist]<br/>";
                              shortcode += "[upside_ulist]List item[/upside_ulist]<br/>";
                              shortcode += "[/upside_ulists]<br/>";
                              return tinyMCE.activeEditor.execCommand("mceInsertContent", 0, shortcode);
                          }
                      },
                      {
                          text: upside_toolkit.i18n.u_list_custom,
                          onclick: function() {
                              var shortcode;
                              shortcode = "[upside_ulists type=\"custom\"]<br/>";
                              shortcode += "[upside_ulist font_awesome_icon=\"fa fa-bolt\"]List item[/upside_ulist]<br/>";
                              shortcode += "[upside_ulist font_awesome_icon=\"fa fa-eye\"]List item[/upside_ulist]<br/>";
                              shortcode += "[upside_ulist font_awesome_icon=\"fa fa-gift\"]List item[/upside_ulist]<br/>";
                              shortcode += "[/upside_ulists]<br/>";
                              return tinyMCE.activeEditor.execCommand("mceInsertContent", 0, shortcode);
                          }
                      },
                      {
                          text: upside_toolkit.i18n.u_list_default,
                          onclick: function() {
                              var shortcode;
                              shortcode = "[upside_ulists type=\"custom\"]<br/>";
                              shortcode += "[upside_ulist font_awesome_icon=\"fa fa-bolt\"]List item[/upside_ulist]<br/>";
                              shortcode += "[upside_ulist font_awesome_icon=\"fa fa-eye\"]List item[/upside_ulist]<br/>";
                              shortcode += "[upside_ulist font_awesome_icon=\"fa fa-gift\"]List item[/upside_ulist]<br/>";
                              shortcode += "[/upside_ulists]<br/>";
                              return tinyMCE.activeEditor.execCommand("mceInsertContent", 0, shortcode);
                          }
                      }
                  ]
              },
            {
              text: upside_toolkit.i18n.tabs,
              onclick: function() {
                var shortcode;
                shortcode = "[upside_tabs]<br/>";
                shortcode += "[upside_tab title=\"Tab title 1\"]Tab content 1[/upside_tab]<br/>";
                shortcode += "[upside_tab title=\"Tab title 2\"]Tab content 2[/upside_tab]<br/>";
                shortcode += "[upside_tab title=\"Tab title 3\"]Tab content 3[/upside_tab]<br/>";
                shortcode += "[/upside_tabs]<br/>";
                return tinyMCE.activeEditor.execCommand("mceInsertContent", 0, shortcode);
              }
            }, {
              text: upside_toolkit.i18n.accordion,
              onclick: function() {
                var shortcode;
                shortcode = "[upside_accordions icon_pos=\"right or left\"]<br/>";
                shortcode += "[upside_accordion title=\"Accordion title 1\"]Accordion content 1[/upside_accordion]<br/>";
                shortcode += "[upside_accordion title=\"Accordion title 2\"]Accordion content 2[/upside_accordion]<br/>";
                shortcode += "[upside_accordion title=\"Accordion title 3\"]Accordion content 3[/upside_accordion]<br/>";
                shortcode += "[/upside_accordions]<br/>";
                return tinyMCE.activeEditor.execCommand("mceInsertContent", 0, shortcode);
              }
            }, {
              text: upside_toolkit.i18n.toggle,
              onclick: function() {
                var shortcode;
                shortcode = "[upside_toggles]<br/>";
                shortcode += "[upside_toggle title=\"Toggle title 1\"]Toggle content 1[/upside_toggle]<br/>";
                shortcode += "[upside_toggle title=\"Toggle title 2\"]Toggle content 2[/upside_toggle]<br/>";
                shortcode += "[upside_toggle title=\"Toggle title 3\"]Toggle content 3[/upside_toggle]<br/>";
                shortcode += "[/upside_toggles]<br/>";
                return tinyMCE.activeEditor.execCommand("mceInsertContent", 0, shortcode);
              }
            },
              {
                  text: upside_toolkit.i18n.table,
                  menu: [
                      {
                          text: upside_toolkit.i18n.price_table,
                          onclick: function() {
                              var shortcode;
                              shortcode = "[upside_price_tables column_per_row=\"4\"]<br/>";
                              shortcode += "[upside_price_table title=\"Price title\" price_value=\"09\" price_currency=\"$\" price_per=\"Month\" special_text=\"\" features=\"Feature 1|Feature 2|Feature 3|Feature 4\" btn_title=\"Sign-up\" btn_link_to=\"#\" btn_link_target=\"_blank\"][/upside_price_table]<br/>";
                              shortcode += "[upside_price_table title=\"Price title\" price_value=\"09\" price_currency=\"$\" price_per=\"Month\" special_text=\"\" features=\"Feature 1|Feature 2|Feature 3|Feature 4\" btn_title=\"Sign-up\" btn_link_to=\"#\" btn_link_target=\"_blank\"][/upside_price_table]<br/>";
                              shortcode += "[upside_price_table title=\"Price title\" price_value=\"09\" price_currency=\"$\" price_per=\"Month\" special_text=\"\" features=\"Feature 1|Feature 2|Feature 3|Feature 4\" btn_title=\"Sign-up\" btn_link_to=\"#\" btn_link_target=\"_blank\"][/upside_price_table]<br/>";
                              shortcode += "[upside_price_table title=\"Price title\" price_value=\"09\" price_currency=\"$\" price_per=\"Month\" special_text=\"\" features=\"Feature 1|Feature 2|Feature 3|Feature 4\" btn_title=\"Sign-up\" btn_link_to=\"#\" btn_link_target=\"_blank\"][/upside_price_table]<br/>";
                              shortcode += "[/upside_price_tables]<br/>";
                              return tinyMCE.activeEditor.execCommand("mceInsertContent", 0, shortcode);
                          }
                      },
                      {
                          text: upside_toolkit.i18n.check_table,
                          onclick: function() {
                              var shortcode;
                              shortcode = "[upside_check_tables]<br/>";
                              shortcode += "[upside_check_table title=\"Column title\" features=\"Feature 1|Feature 2|Feature 3|Feature 4|Feature 5\" btn_title=\"Buy now\" btn_link_to=\"#\" btn_link_target=\"_blank\" btn_show=\"0\"][/upside_check_table]<br/>";
                              shortcode += "[upside_check_table title=\"Column title\" features=\"check|check|uncheck|uncheck|Description\" btn_title=\"Buy now\" btn_link_to=\"#\" btn_link_target=\"_blank\" btn_show=\"1\"][/upside_check_table]<br/>";
                              shortcode += "[upside_check_table title=\"Column title\" features=\"check|check|uncheck|uncheck|Description\" btn_title=\"Buy now\" btn_link_to=\"#\" btn_link_target=\"_blank\" btn_show=\"1\"][/upside_check_table]<br/>";
                              shortcode += "[upside_check_table title=\"Column title\" features=\"check|check|uncheck|uncheck|Description\" btn_title=\"Buy now\" btn_link_to=\"#\" btn_link_target=\"_blank\" btn_show=\"1\"][/upside_check_table]<br/>";
                              shortcode += "[upside_check_table title=\"Column title\" features=\"check|check|uncheck|uncheck|Description\" btn_title=\"Buy now\" btn_link_to=\"#\" btn_link_target=\"_blank\" btn_show=\"1\"][/upside_check_table]<br/>";
                              shortcode += "[/upside_check_tables]<br/>";
                              return tinyMCE.activeEditor.execCommand("mceInsertContent", 0, shortcode);
                          }
                      }
                  ]
              },
              {
                  text: upside_toolkit.i18n.contact,
                  onclick: function() {
                      var shortcode;
                      shortcode = "[upside_contact_form_7 u_title=\"Get in touch\" u_description=\"Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore.\"]<br/>";
                      shortcode += "[contact-form-7 id=\"FORM_ID\" title=\"Title of contact form 7\"]<br/>";
                      shortcode += "[/upside_contact_form_7]<br/>";
                      return tinyMCE.activeEditor.execCommand("mceInsertContent", 0, shortcode);
                  }
              },

          ]
        }, {
          text: upside_toolkit.i18n.dropcap,
          icon: "dropcap",
          menu: [
            {
              text: upside_toolkit.i18n.transparent,
              onclick: function() {
                return tinyMCE.activeEditor.execCommand("mceInsertContent", 0, "[upside_dropcap class=\"kp-dropcap-1\" f_char=\"\"]" + tinyMCE.activeEditor.selection.getContent() + "[/upside_dropcap]");
              }
            }, {
              text: upside_toolkit.i18n.circle,
              onclick: function() {
                return tinyMCE.activeEditor.execCommand("mceInsertContent", 0, "[upside_dropcap class=\"kp-dropcap-2\" f_char=\"\"]" + tinyMCE.activeEditor.selection.getContent() + "[/upside_dropcap]");
              }
            }
          ]
        }, {
          text: upside_toolkit.i18n.alert,
          menu: [
            {
              text: upside_toolkit.i18n.blue,
              onclick: function() {
                return tinyMCE.activeEditor.execCommand("mceInsertContent", 0, "[upside_alert class=\"alert alert-dark-blue alert-dismissable\" font_awesome_icon=\"fa fa-check\"]" + tinyMCE.activeEditor.selection.getContent() + "[/upside_alert]");
              }
            },
            {
              text: upside_toolkit.i18n.yellow,
              onclick: function() {
                return tinyMCE.activeEditor.execCommand("mceInsertContent", 0, "[upside_alert class=\"alert alert-yellow alert-dismissable\" font_awesome_icon=\"fa fa-gavel\"]" + tinyMCE.activeEditor.selection.getContent() + "[/upside_alert]");
              }
            },
            {
              text: upside_toolkit.i18n.green,
              onclick: function() {
                  return tinyMCE.activeEditor.execCommand("mceInsertContent", 0, "[upside_alert class=\"alert alert-green alert-dismissable\" font_awesome_icon=\"fa fa-pencil\"]" + tinyMCE.activeEditor.selection.getContent() + "[/upside_alert]");
              }
            },
            {
              text: upside_toolkit.i18n.pink,
              onclick: function() {
                  return tinyMCE.activeEditor.execCommand("mceInsertContent", 0, "[upside_alert class=\"alert alert-pink alert-dismissable\" font_awesome_icon=\"fa fa-bolt\"]" + tinyMCE.activeEditor.selection.getContent() + "[/upside_alert]");
              }
            },
            {
              text: upside_toolkit.i18n.sky,
              onclick: function() {
                  return tinyMCE.activeEditor.execCommand("mceInsertContent", 0, "[upside_alert class=\"alert alert-sky alert-dismissable\" font_awesome_icon=\"fa fa-umbrella\"]" + tinyMCE.activeEditor.selection.getContent() + "[/upside_alert]");
              }
            }
          ]
        },
          {
              text: upside_toolkit.i18n.sticky,
              menu: [
                  {
                      text: upside_toolkit.i18n.sky,
                      onclick: function() {
                          return tinyMCE.activeEditor.execCommand("mceInsertContent", 0, "[upside_sticky class=\"sticky-note sticky-sky\"]" + tinyMCE.activeEditor.selection.getContent() + "[/upside_sticky]");
                      }
                  },
                  {
                      text: upside_toolkit.i18n.orange,
                      onclick: function() {
                          return tinyMCE.activeEditor.execCommand("mceInsertContent", 0, "[upside_sticky class=\"sticky-note sticky-orange\"]" + tinyMCE.activeEditor.selection.getContent() + "[/upside_sticky]");
                      }
                  },
                  {
                      text: upside_toolkit.i18n.pink,
                      onclick: function() {
                          return tinyMCE.activeEditor.execCommand("mceInsertContent", 0, "[upside_sticky class=\"sticky-note sticky-pink\"]" + tinyMCE.activeEditor.selection.getContent() + "[/upside_sticky]");
                      }
                  },
                  {
                      text: upside_toolkit.i18n.green,
                      onclick: function() {
                          return tinyMCE.activeEditor.execCommand("mceInsertContent", 0, "[upside_sticky class=\"sticky-note sticky-green\"]" + tinyMCE.activeEditor.selection.getContent() + "[/upside_sticky]");
                      }
                  }
              ]
          },
          {
          text: upside_toolkit.i18n.button,
          menu: [
            {
              text: upside_toolkit.i18n.pink,
              menu: [
                {
                  text: upside_toolkit.i18n.small,
                  onclick: function() {
                    return tinyMCE.activeEditor.execCommand("mceInsertContent", 0, "[upside_button class=\"kopa-button pink-button small-button kopa-button-icon\" link=\"#\" target=\"\"]Button text[/upside_button]");
                  }
                },
                {
                  text: upside_toolkit.i18n.medium,
                  onclick: function() {
                    return tinyMCE.activeEditor.execCommand("mceInsertContent", 0, "[upside_button class=\"kopa-button pink-button medium-button kopa-button-icon\" link=\"#\" target=\"\"]Button text[/upside_button]");
                  }
                },
                {
                  text: upside_toolkit.i18n.large,
                  onclick: function() {
                    return tinyMCE.activeEditor.execCommand("mceInsertContent", 0, "[upside_button class=\"kopa-button pink-button large-button kopa-button-icon\" link=\"#\" target=\"\"]Button text[/upside_button]");
                  }
                },
                {
                  text: upside_toolkit.i18n.small_line,
                  onclick: function() {
                      return tinyMCE.activeEditor.execCommand("mceInsertContent", 0, "[upside_button class=\"kopa-button kopa-line-button pink-button small-button kopa-button-icon\" link=\"#\" target=\"\"]Button text[/upside_button]");
                  }
                },
                {
                  text: upside_toolkit.i18n.medium_line,
                  onclick: function() {
                      return tinyMCE.activeEditor.execCommand("mceInsertContent", 0, "[upside_button class=\"kopa-button kopa-line-button pink-button medium-button kopa-button-icon\" link=\"#\" target=\"\"]Button text[/upside_button]");
                  }
                },
                {
                  text: upside_toolkit.i18n.large_line,
                  onclick: function() {
                      return tinyMCE.activeEditor.execCommand("mceInsertContent", 0, "[upside_button class=\"kopa-button kopa-line-button pink-button large-button kopa-button-icon\" link=\"#\" target=\"\"]Button text[/upside_button]");
                  }
                }
              ]
            },
            {
                text: upside_toolkit.i18n.blue,
                menu: [
                    {
                      text: upside_toolkit.i18n.small,
                      onclick: function() {
                        return tinyMCE.activeEditor.execCommand("mceInsertContent", 0, "[upside_button class=\"kopa-button blue-button small-button kopa-button-icon\" link=\"#\" target=\"\"]Button text[/upside_button]");
                      }
                    },
                    {
                      text: upside_toolkit.i18n.medium,
                      onclick: function() {
                        return tinyMCE.activeEditor.execCommand("mceInsertContent", 0, "[upside_button class=\"kopa-button blue-button medium-button kopa-button-icon\" link=\"#\" target=\"\"]Button text[/upside_button]");
                      }
                    },
                    {
                      text: upside_toolkit.i18n.large,
                      onclick: function() {
                        return tinyMCE.activeEditor.execCommand("mceInsertContent", 0, "[upside_button class=\"kopa-button blue-button large-button kopa-button-icon\" link=\"#\" target=\"\"]Button text[/upside_button]");
                      }
                    },
                    {
                        text: upside_toolkit.i18n.small_line,
                        onclick: function() {
                            return tinyMCE.activeEditor.execCommand("mceInsertContent", 0, "[upside_button class=\"kopa-button kopa-line-button blue-button small-button kopa-button-icon\" link=\"#\" target=\"\"]Button text[/upside_button]");
                        }
                    },
                    {
                        text: upside_toolkit.i18n.medium_line,
                        onclick: function() {
                            return tinyMCE.activeEditor.execCommand("mceInsertContent", 0, "[upside_button class=\"kopa-button kopa-line-button blue-button medium-button kopa-button-icon\" link=\"#\" target=\"\"]Button text[/upside_button]");
                        }
                    },
                    {
                        text: upside_toolkit.i18n.large_line,
                        onclick: function() {
                            return tinyMCE.activeEditor.execCommand("mceInsertContent", 0, "[upside_button class=\"kopa-button kopa-line-button blue-button large-button kopa-button-icon\" link=\"#\" target=\"\"]Button text[/upside_button]");
                        }
                    }
                ]
            },
              {
                  text: upside_toolkit.i18n.navy,
                  menu: [
                      {
                          text: upside_toolkit.i18n.small,
                          onclick: function() {
                              return tinyMCE.activeEditor.execCommand("mceInsertContent", 0, "[upside_button class=\"kopa-button navy-button small-button kopa-button-icon\" link=\"#\" target=\"\"]Button text[/upside_button]");
                          }
                      }, {
                          text: upside_toolkit.i18n.medium,
                          onclick: function() {
                              return tinyMCE.activeEditor.execCommand("mceInsertContent", 0, "[upside_button class=\"kopa-button navy-button medium-button kopa-button-icon\" link=\"#\" target=\"\"]Button text[/upside_button]");
                          }
                      }, {
                          text: upside_toolkit.i18n.large,
                          onclick: function() {
                              return tinyMCE.activeEditor.execCommand("mceInsertContent", 0, "[upside_button class=\"kopa-button navy-button large-button kopa-button-icon\" link=\"#\" target=\"\"]Button text[/upside_button]");
                          }
                      },
                      {
                          text: upside_toolkit.i18n.small_line,
                          onclick: function() {
                              return tinyMCE.activeEditor.execCommand("mceInsertContent", 0, "[upside_button class=\"kopa-button kopa-line-button navy-button small-button kopa-button-icon\" link=\"#\" target=\"\"]Button text[/upside_button]");
                          }
                      },
                      {
                          text: upside_toolkit.i18n.medium_line,
                          onclick: function() {
                              return tinyMCE.activeEditor.execCommand("mceInsertContent", 0, "[upside_button class=\"kopa-button kopa-line-button navy-button medium-button kopa-button-icon\" link=\"#\" target=\"\"]Button text[/upside_button]");
                          }
                      },
                      {
                          text: upside_toolkit.i18n.large_line,
                          onclick: function() {
                              return tinyMCE.activeEditor.execCommand("mceInsertContent", 0, "[upside_button class=\"kopa-button kopa-line-button navy-button large-button kopa-button-icon\" link=\"#\" target=\"\"]Button text[/upside_button]");
                          }
                      }
                  ]
              },
              {
                  text: upside_toolkit.i18n.green,
                  menu: [
                      {
                          text: upside_toolkit.i18n.small,
                          onclick: function() {
                              return tinyMCE.activeEditor.execCommand("mceInsertContent", 0, "[upside_button class=\"kopa-button green-button small-button kopa-button-icon\" link=\"#\" target=\"\"]Button text[/upside_button]");
                          }
                      }, {
                          text: upside_toolkit.i18n.medium,
                          onclick: function() {
                              return tinyMCE.activeEditor.execCommand("mceInsertContent", 0, "[upside_button class=\"kopa-button green-button medium-button kopa-button-icon\" link=\"#\" target=\"\"]Button text[/upside_button]");
                          }
                      }, {
                          text: upside_toolkit.i18n.large,
                          onclick: function() {
                              return tinyMCE.activeEditor.execCommand("mceInsertContent", 0, "[upside_button class=\"kopa-button green-button large-button kopa-button-icon\" link=\"#\" target=\"\"]Button text[/upside_button]");
                          }
                      },
                      {
                          text: upside_toolkit.i18n.small_line,
                          onclick: function() {
                              return tinyMCE.activeEditor.execCommand("mceInsertContent", 0, "[upside_button class=\"kopa-button kopa-line-button green-button small-button kopa-button-icon\" link=\"#\" target=\"\"]Button text[/upside_button]");
                          }
                      },
                      {
                          text: upside_toolkit.i18n.medium_line,
                          onclick: function() {
                              return tinyMCE.activeEditor.execCommand("mceInsertContent", 0, "[upside_button class=\"kopa-button kopa-line-button green-button medium-button kopa-button-icon\" link=\"#\" target=\"\"]Button text[/upside_button]");
                          }
                      },
                      {
                          text: upside_toolkit.i18n.large_line,
                          onclick: function() {
                              return tinyMCE.activeEditor.execCommand("mceInsertContent", 0, "[upside_button class=\"kopa-button kopa-line-button green-button large-button kopa-button-icon\" link=\"#\" target=\"\"]Button text[/upside_button]");
                          }
                      }
                  ]
              },
              {
                  text: upside_toolkit.i18n.red,
                  menu: [
                      {
                          text: upside_toolkit.i18n.small,
                          onclick: function() {
                              return tinyMCE.activeEditor.execCommand("mceInsertContent", 0, "[upside_button class=\"kopa-button red-button small-button kopa-button-icon\" link=\"#\" target=\"\"]Button text[/upside_button]");
                          }
                      }, {
                          text: upside_toolkit.i18n.medium,
                          onclick: function() {
                              return tinyMCE.activeEditor.execCommand("mceInsertContent", 0, "[upside_button class=\"kopa-button red-button medium-button kopa-button-icon\" link=\"#\" target=\"\"]Button text[/upside_button]");
                          }
                      }, {
                          text: upside_toolkit.i18n.large,
                          onclick: function() {
                              return tinyMCE.activeEditor.execCommand("mceInsertContent", 0, "[upside_button class=\"kopa-button red-button large-button kopa-button-icon\" link=\"#\" target=\"\"]Button text[/upside_button]");
                          }
                      },
                      {
                          text: upside_toolkit.i18n.small_line,
                          onclick: function() {
                              return tinyMCE.activeEditor.execCommand("mceInsertContent", 0, "[upside_button class=\"kopa-button kopa-line-button red-button small-button kopa-button-icon\" link=\"#\" target=\"\"]Button text[/upside_button]");
                          }
                      },
                      {
                          text: upside_toolkit.i18n.medium_line,
                          onclick: function() {
                              return tinyMCE.activeEditor.execCommand("mceInsertContent", 0, "[upside_button class=\"kopa-button kopa-line-button red-button medium-button kopa-button-icon\" link=\"#\" target=\"\"]Button text[/upside_button]");
                          }
                      },
                      {
                          text: upside_toolkit.i18n.large_line,
                          onclick: function() {
                              return tinyMCE.activeEditor.execCommand("mceInsertContent", 0, "[upside_button class=\"kopa-button kopa-line-button red-button large-button kopa-button-icon\" link=\"#\" target=\"\"]Button text[/upside_button]");
                          }
                      }
                  ]
              }
          ]
        },{
          text: upside_toolkit.i18n.caption,
          onclick: function() {
            var shortcode;
            shortcode = "[upside_caption title='Title']Description[/upside_caption]<br/>";
            return tinyMCE.activeEditor.execCommand("mceInsertContent", 0, shortcode);
          }
        },
          {
              text: upside_toolkit.i18n.blockquote,
              onclick: function() {
                  return tinyMCE.activeEditor.execCommand("mceInsertContent", 0, "[upside_blockquote]" + tinyMCE.activeEditor.selection.getContent() + "[/upside_blockquote]");
              }
          },
          {
              text: upside_toolkit.i18n.progress,
              menu: [

                  {
                      text: upside_toolkit.i18n.small,
                      menu: [
                          {
                              text: upside_toolkit.i18n.blue,
                              onclick: function() {
                                  return tinyMCE.activeEditor.execCommand("mceInsertContent", 0, "[upside_progress class=\"pro-bar-wrapper pro-blue\" icon_text=\"\" font_awesome_icon=\"fa fa-code\" bar_percent=\"85\" bar_delay=\"400\"]" + tinyMCE.activeEditor.selection.getContent() + "[/upside_progress]");
                              }
                          },
                          {
                              text: upside_toolkit.i18n.pink,
                              onclick: function() {
                                  return tinyMCE.activeEditor.execCommand("mceInsertContent", 0, "[upside_progress class=\"pro-bar-wrapper pro-pink\" icon_text=\"\" font_awesome_icon=\"fa fa-code\" bar_percent=\"85\" bar_delay=\"400\"]" + tinyMCE.activeEditor.selection.getContent() + "[/upside_progress]");
                              }
                          }
                      ]
                  },

                  {
                      text: upside_toolkit.i18n.medium,
                      menu : [
                          {
                              text: upside_toolkit.i18n.blue,
                              onclick: function() {
                                  return tinyMCE.activeEditor.execCommand("mceInsertContent", 0, "[upside_progress class=\"pro-bar-wrapper pro-blue style2\" icon_text=\"\" font_awesome_icon=\"fa fa-code\" bar_percent=\"85\" bar_delay=\"400\"]" + tinyMCE.activeEditor.selection.getContent() + "[/upside_progress]");
                              }
                          },
                          {
                              text: upside_toolkit.i18n.pink,
                              onclick: function() {
                                  return tinyMCE.activeEditor.execCommand("mceInsertContent", 0, "[upside_progress class=\"pro-bar-wrapper pro-pink style2\" icon_text=\"\" font_awesome_icon=\"fa fa-code\" bar_percent=\"85\" bar_delay=\"400\"]" + tinyMCE.activeEditor.selection.getContent() + "[/upside_progress]");
                              }
                          }
                      ]
                  }



              ]
          },
          {
              text: upside_toolkit.i18n.hightlight,
              onclick: function() {
                  return tinyMCE.activeEditor.execCommand("mceInsertContent", 0, "[upside_hightlight text_decoration=\"underline\" color=\"#ed145b\"]" + tinyMCE.activeEditor.selection.getContent() + "[/upside_hightlight]");
              }
          }
      ]
    });
  });
})();
