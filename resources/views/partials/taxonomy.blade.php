<link rel="stylesheet" href="{{asset('css/Aimara.css')}}">

<div style="float: right; width: 100%; white-space: nowrap" id="div_tree"></div>

<script src="{{asset('js/scripts/Aimara.js')}}"></script>

<script>
    var lastNode = '';
    window.onload = function() {

        //Initializing Tree

        //Tree Context Menu Structure
        var contex_menu = {
            'context1' : {
                elements : [
                    {
                        text : 'Toggle Node',
                        icon: '/images/leaf.png',
                        action : function(node) {
                            if(node.has_children){
                                node.toggleNode();
                            }
                        }
                    },
                    {
                        text : 'Expand Node',
                        icon: '/images/leaf.png',
                        action : function(node) {
                            node.expandNode();
                        }
                    },
                    {
                        text : 'Collapse Node',
                        icon: '/images/leaf.png',
                        action : function(node) {
                            node.collapseNode();
                        }
                    },
                    {
                        text : 'Expand Subtree',
                        icon: '/images/tree.png',
                        action : function(node) {
                            node.expandSubtree();
                        }
                    },
                    {
                        text : 'Collapse Subtree',
                        icon: '/images/tree.png',
                        action : function(node) {
                            node.collapseSubtree();
                        }
                    },
                    {
                        text : 'Create Child Element',
                        icon: '/images/add1.png',
                        action : function(node) {
                            lastNode = node;

                            $('#extensionTagModal').modal('toggle', $(this));

                            // $('body').removeClass('brand-minimized sidebar-minimized');
                            // $('.create-tag-div').show();
                            // $('#discard-tag').show();
                            // $('#create-tag-button').hide();
                        }
                    },
                    {
                        text : 'Delete Element',
                        icon: '/images/delete.png',
                        action : function(node) {
                            node.removeNode();
                        }
                    },

                    /*{
                        text : 'Delete Child Nodes',
                        icon: '/images/delete.png',
                        action : function(node) {
                            node.removeChildNodes();
                        }
                    }*/
                ]
            },

            'context2' : {
                elements : [
                    {
                        text : 'Delete Element',
                        icon: '/images/delete.png',
                        action : function(node) {
                            node.removeNode();
                        }
                    },

                    /*{
                        text : 'Delete Child Nodes',
                        icon: '/images/delete.png',
                        action : function(node) {
                            node.removeChildNodes();
                        }
                    }*/
                ]
            }
        };

        //Creating the tree
        let tree = createTree('div_tree','white',contex_menu);

        $.ajax({
            type: 'GET',
            data: {
                'id': '0',
                'company_id': '0'
            },
            dataType: 'json',
            url: '/taxonomy/get-taxonomy-parents',
            success: function(parents) {
                $.each(parents, function(index, element) {
                    tree.createNode(element['label'], false, '/images/star.png', null, null, 'context1', element['id'], true, element['code']);
                });
            }
        });

        //Rendering the tree
        tree.drawTree();

        //Adding node after tree is already rendered
        tree.createNode('2019 TAXONOMY',false, '/images/leaf.png',null,null,null, -1, false);

    };

    function expand_all() {
        tree.expandTree();
    }

    /*       function clear_log() {
               document.getElementById('div_log').innerHTML = '';
           }*/

    function collapse_all() {
        tree.collapseTree();
    }

</script>
