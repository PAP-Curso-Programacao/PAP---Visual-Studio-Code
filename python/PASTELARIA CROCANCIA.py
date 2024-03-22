from flet import *
from flet_core.control_event import ControlEvent
from flet_core.view import View 
import sqlite3
#from kivy.graphics import border_radius
#from kivymd.utils import border_radius

def main(page: Page):

    page.title = 'Pastelaria'

    #Finalizado
    def InfoProduto():
        connect = sqlite3.connect("Pastelaria.db")
        cursor = connect.cursor()
        produtos = []
        for cont in cursor.execute("SELECT Nome FROM Produtos"):
            produtos.append(cont)
        connect.close()
        return produtos
    
    def IdProduto():
        connect = sqlite3.connect("Pastelaria.db")
        cursor = connect.cursor()
        cursor.execute(f"Select Count(*) from Produtos")
        cat = cursor.fetchone()[0]
        connect.close()
        return cat+1
    
    def IdCliente():
        connect = sqlite3.connect("Pastelaria.db")
        cursor = connect.cursor()
        cursor.execute(f"Select Count(*) from Clientes")
        cat = cursor.fetchone()[0]
        connect.close()
        return cat+1
    
    def OnOffCliente(ID):
        
        connect = sqlite3.connect("Pastelaria.db")
        cursor = connect.cursor()
        cursor.execute(f"Select Atividade from Clientes where ID = ?",(ID,))
        atividade = cursor.fetchone()[0]
        
        # Alternar a atividade
        nova_atividade = 0 if atividade == 1 else 1
        
        cursor.execute(f'UPDATE Clientes set Atividade = ? WHERE ID = ?', (nova_atividade, ID))
        
        connect.commit()
        page.update()
        connect.close()
        

    def shrink(e):
        page_2.controls[0].width = 120
        page_2.controls[0].scale = transform.Scale(
        0.8,alignment= alignment.center_right)
        page_2.update()

    #Finalizado
    def restore(e):
        page_2.controls[0].width = 400
        page_2.controls[0].border_radius = 35
        page_2.controls[0].scale = transform.Scale(
        1,alignment= alignment.center_right)
        page_2.update()

    def UniProduto(ID):
        connect = sqlite3.connect("Pastelaria.db")
        cursor = connect.cursor()
        cursor.execute('SELECT * FROM Produtos WHERE ID = ?', (ID,))
        row = cursor.fetchone()
        connect.close()

        if row is None:
            return Text(f"Product not found.{row}")
        
        return Container(
            width=400,
            height=660,
            bgcolor='#efece3',
            border_radius=35,
            padding=padding.only(
                top=50, left=20, right=20, bottom=5
            ),
            content=Column(
                scroll='auto',
                controls=[
                    Row(alignment='spaceBetween',
                        controls=[
                            Container(on_click=lambda _: page.go('/'), content=Icon(icons.EXIT_TO_APP, color='BLACK')),
                            Row(
                                controls=[
                                    Text(f'ID: {ID}', color='Black', size=30)
                                ]
                            )
                        ]
                    ),
                    Text('Nome', color="black"),
                    TextField(label=row[1],color='Black',border_color='#cd9595',height=40),
                    Text('Preço', color='black'),
                    TextField(label=row[2],color='Black',height=40),
                    Text('Descrição', color='Black'),
                    TextField(label=row[3],color='Black',height=40),
                    Text('Stock', color='Black'),
                    TextField(label=row[4],color='Black',height=40),
                    Image(src=row[5],width=100,height=100),
                    Row(alignment='spaceBetween',
                    controls=[
                        Container(content=ElevatedButton(text='Submit',color="White",bgcolor='#cd9452',width=150,on_click=lambda _: page.go('/'),),
                            ),
                        Container(height=20),
                        Container(content=ElevatedButton(text='Cancel',color="White",bgcolor='RED',width=150,on_click=lambda _: page.go('/'))),
                        ]
                    ),
                ]
            )
        )


    #Pagina Adicionar Produtos
    # Suponha que você tenha variáveis para armazenar os valores dos campos de texto

    # Funções para atualizar as variáveis quando o texto nos campos de texto muda
    def update_nome_produto(new_value):
        global nome_produto
        nome_produto = new_value

    def update_preco_produto(new_value):
        global preco_produto
        preco_produto = new_value

    def update_descricao_produto(new_value):
        global descricao_produto
        descricao_produto = new_value

    def update_stock_produto(new_value):
        global stock_produto
        stock_produto = new_value

    def update_imagem_produto(new_value):
        global imagem_produto
        imagem_produto = new_value

    def addProduto():
        conn = sqlite3.connect('Pastelaria.db')
        cursor = conn.cursor()

        cursor.execute('INSERT INTO Produtos (Nome, Preço, Descrição, Stock, Imagem) VALUES (?, ?, ?, ?, ?)', (nome_produto, preco_produto, descricao_produto, stock_produto, imagem_produto,))
        conn.commit()
        conn.close()
        add_produto_view.update()



    add_produto_view = Container(
        width=400,
        height=660,
        bgcolor='#efece3',
        border_radius=35,
        padding=padding.only(
            top=50, left=20, right=20, bottom=5
        ),
        content=Column(
            controls=[
                Row(alignment='spaceBetween',
                    controls=[
                        Container(on_click=lambda _: page.go('/'), content=Icon(icons.EXIT_TO_APP, color='BLACK')),
                        Row(
                            controls=[
                                Text(f'ID: {IdProduto()}', color='Black', size=30)
                            ]
                        )
                    ]
                ),
                Container(height=10),
                TextField(label='Nome', color="black", on_change=update_nome_produto, border=InputBorder.UNDERLINE,),
                Container(height=10),
                TextField(label='Preço', color='black', on_change=update_preco_produto, border=InputBorder.UNDERLINE,),
                Container(height=10),
                TextField(label='Descrição', color='Black', on_change=update_descricao_produto, border=InputBorder.UNDERLINE,),
                Container(height=10),
                TextField(label='Stock', color='Black', on_change=update_stock_produto, border=InputBorder.UNDERLINE,),
                Container(height=10),
                TextField(label='Imagem', color='Black', on_change=update_imagem_produto, border=InputBorder.UNDERLINE),
                Container(height=10),
                Row(alignment='spaceBetween',
                    controls=[
                        Container(
                                content=ElevatedButton(
                                    text='Submit',
                                    color="White",
                                    on_click=lambda _: (addProduto(),page.go('/')),
                                    bgcolor='#cd9452',
                                    width=150
                                )
                            ),
                        Container(height=20),
                        Container(on_click=lambda _: page.go('/'), content=ElevatedButton(text='Cancel', color="White",
                                                                                        bgcolor='RED', width=150)),
                    ]
                ),
            ], )
    )

    info_clientes_view = Container(
        width=400,
        height=660,
        bgcolor='#efece3',
        border_radius=35,
        padding=padding.only(
                    top=50,left=20,right=20,bottom=5
                ),
        content=Column(   
            scroll='Auto',
            controls=[
                Row(alignment='spaceBetween',
                    controls=[
                        Container(on_click=lambda _: page.go('/'),content=Icon(icons.EXIT_TO_APP,color='BLACK'),
                            ),
                        ]
                    ),
            ]
    )
    )

    def desativarCliente(id):
        return ElevatedButton(
            height=20,
            width=150,
            bgcolor='Red',
            text='Desativar',
            color='White',
            on_click=lambda _: OnOffCliente(id)
    )
    

    def ativarCliente(id):
        return ElevatedButton(
            height=20,
            width=150,
            bgcolor='Green',
            text='Ativar',
            color='White',
            on_click=lambda _: OnOffCliente(id)
        )

    connect = sqlite3.connect("Pastelaria.db")
    cursor = connect.cursor()

    for cont in cursor.execute('SELECT * FROM Clientes'):
        id = cont[0] 
        if cont[6] == 1:
            info_clientes_view.content.controls.append(
                Container(
                    border_radius=20,
                    bgcolor='#cd9452',
                    height=310,
                    width=400,
                    padding=15,
                    content=Column(
                        controls=[
                                Image(src='PAP\\Imagem\\bolasberlim.jpg',width=400,height=100),
                                Text(f'ID: {cont[0]}',color="Black",size=17),
                                Text(f'{cont[1]}',color="White",size=20),
                                Text(cont[2],color='Black',size=12),
                                Text(cont[4],color='Black',size=12),
                                Text(cont[5],color='Black',size=12),
                                Row(
                                    controls=[desativarCliente(id)]
                                ),
                        ]
                    )
                )
            )
        else:
            info_clientes_view.content.controls.append(
                Container(
                    border_radius=20,
                    bgcolor='#cd9452',
                    height=310,
                    width=400,
                    padding=15,
                    content=Column(
                        controls=[
                            Image(src='PAP\\Imagem\\bolasberlim.jpg',width=400,height=100),
                            Text(f'ID: {cont[0]}',color="Black",size=17),
                            Text(f'{cont[1]}',color="White",size=20),
                            Text(cont[2],color='Black',size=12),
                            Text(cont[4],color='Black',size=12),
                            Text(cont[5],color='Black',size=12),
                            Row(
                                controls=[ativarCliente(id)]
                            ),
                        ]
                    )
                )
            )
    connect.close()

    def enviarPedido(ID):
        connect = sqlite3.connect("Pastelaria.db")
        cursor = connect.cursor()

        cursor.execute(f'UPDATE Pedidos set Status = ? WHERE ID = ?', (1, ID))
        
        connect.commit()
        connect.close()

    def entregarPedido(id):
        return ElevatedButton(
            height=20,
            width=150,
            bgcolor='Red',
            text='Entregar',
            color='White',
            on_click=lambda _: enviarPedido(id)
        )

    info_pedidos_view = Container(
        width=400,
        height=660,
        bgcolor='#efece3',
        border_radius=35,
        padding=padding.only(
                    top=50,left=20,right=20,bottom=5
                ),
        content=Column(   scroll='Auto',
            controls=[
                Row(alignment='spaceBetween',
                    controls=[
                        
                        Container(on_click=lambda _: page.go('/'),content=Icon(icons.EXIT_TO_APP,color='BLACK'),
                            ),
                        Text('Pedidos',size=20,color='black')
                        
                        ]
                    ),
            ]
    )
    )


    connect = sqlite3.connect("Pastelaria.db")
    cursor = connect.cursor()

    for cont in cursor.execute('SELECT * FROM Pedidos'):
        id = cont[0] 
        if cont[3] == '1':
            info_pedidos_view.content.controls.append(
                Container(
                    border_radius=20,
                    bgcolor='#cd9452',
                    height=150,
                    width=360,
                    padding=15,
                    content=Column(
                        controls=[
                            Text(f'ID: {cont[0]}',color="Black",size=17),
                            Text(f'{cont[2]}',color="White",size=20),
                            Text(cont[4],color='Black',size=12),
                            Row(
                                controls=[Text('Entregue',height=20,
                                               width=150,
                                               bgcolor='Green',
                                               
                                               color='White',)]
                            )
                        ]
                    )
                )
            )
        else:
            info_pedidos_view.content.controls.append(
                Container(
                    border_radius=20,
                    bgcolor='#cd9452',
                    height=150,
                    width=360,
                    padding=15,
                    content=Column(
                        controls=[
                            Text(f'ID: {cont[0]}',color="Black",size=17),
                            Text(f'{cont[2]}',color="White",size=20),
                            Text(cont[4],color='Black',size=12),
                            Row(
                                controls=[entregarPedido(id)]
                            )
                        ]
                    )
                )
            )
    connect.close()




    produto = Column(
        spacing=10,
        height=200,
        width=400,
        scroll=ScrollMode.ALWAYS,
        on_scroll_interval=0,
    )

    connect = sqlite3.connect("Pastelaria.db")
    cursor = connect.cursor()
    cursor.execute(f"Select Count(*) from Produtos")
    cat = cursor.fetchone()[0]
    for cont in range(cat):
        produto.controls.append(
            Container(
                content=ElevatedButton(
                height=50,
                width=400,
                bgcolor='#cd9452',
                text=''.join(InfoProduto()[cont]),
                on_click=lambda _,id = cont: (page.go(f'/info_produto/{id + 1}')),
                color='White',
            )
            )
        )
    connect.close()



    categories_card = Row(
           scroll= 'auto'
    )

    categories = ['Clientes','Produtos','Pedidos']
    for category in categories:
        connect = sqlite3.connect("Pastelaria.db")
        cursor = connect.cursor()
        cursor.execute(f"Select Count(*) from {category}")
        cat = cursor.fetchone()[0]
        categories_card.controls.append(
              Container(
                    border_radius=20,
                    bgcolor='WHITE',
                    height=110,
                    width=170,
                    padding=15,
                    content=Column(
                        controls=[
                        Text(category,color="Black",size=17),
                        Text(cat,color="#cd9452",size=20),]
                    )
              )
        )
        connect.close()

    first_page_contents = Container(
        content=Column(
            controls=[
                Row(alignment='spaceBetween',
                    controls=[
                        Container(on_click=lambda e: shrink(e),
                            content=Icon(icons.MENU,color='BLACK')
                            ),
                        Row(
                            controls=[
                                Icon(icons.SEARCH,color='BLACK'),
                                Icon(icons.NOTIFICATIONS_OUTLINED,color='BLACK')
                            ]
                        )
                        ]
                    ),
                Container(height=20),
                Text(
                    value='CATEGORIAS',
                    color='BLACK'
                ),
                Container(
                       padding=padding.only(top=10,bottom=20,),
                       content=categories_card
                ), 
                Text('PRODUTOS',color="BLACK"),
                produto,
                Container(height=10),
                FloatingActionButton(bgcolor='Black',
                            icon = icons.ADD,
                            on_click=lambda _:page.go('/add_produto')
                        )
                ],
            ),
        )

    page_1 = Container(
        width=400,
        height=850,
        bgcolor='#fff',
        border_radius=35,
        padding=padding.only(left=50,top=60,right=200),

        content=Column(
        controls=[
        Row(alignment='end',
        controls=[
            Container(border_radius=25,
            padding=padding.only(
            top=13,left=13,),
            height=50,
            width=50,
            on_click=lambda e: restore(e),
            content=Icon(icons.KEYBOARD_RETURN_SHARP,color='black')
            )
            ]
            ),
                        Text('Pastelaria Crocância',color='black',size=20
        ),
            Container(height=20),
            #circle,
            Text('CATEGORIAS',size=23,weight='bold',color='Black'),
            Container(height=25),
            Row(controls=[ Icon(icons.PERSON,color='black'),Container( on_click=lambda _:page.go('/info_clientes'),
            content=
            Text('Clientes',size=15,weight=FontWeight.W_300,color='black',font_family='poppins'),)
            ]),
            Container(height=5),
            Row(controls=[ Icon(icons.MONEY_OFF_CSRED_ROUNDED,color='black'),Container( on_click=lambda _:page.go('/info_pedidos'),
            content=
            Text('Pedidos',size=15,weight=FontWeight.W_300,color='black',font_family='poppins'),)
            ]),
        
        ]
        )
    )


    page_2 = Row(alignment='end',
        controls=[
            Container(
                width=400,
                height=850,
                bgcolor='#efece3',
                border_radius=30,
                animate = animation.Animation(600,AnimationCurve.DECELERATE),
                animate_scale = animation.Animation(400,curve='decelerate'),
                padding=padding.only(
                    top=50,left=20,right=20,bottom=5
                ),
                content=Column(
                    controls=[
                        first_page_contents
                    ]
                )
            )
        ]
    )

    container = Container(
        width=400,
        height=660,
        bgcolor='#efece3',
        border_radius=35,
        content = Stack(
            controls = [
                page_1,page_2,
            ]
        )
    )

    pages = {
    '/': View(
        "/",
        [
            container
        ],
    ),
    '/add_produto': View(
        "/add_produto",
        [
            add_produto_view
        ],
    ),
    '/info_clientes': View(
        "/info_clientes",
        [
            info_clientes_view
        ],
    ),
    '/info_pedidos':View(
        '/info_pedidos',
        [
            info_pedidos_view
        ],
    )
}

# Add views for each info_produto route
    for cont in range(0,IdProduto()):
        pages[f'/info_produto/{cont}'] = View(
            f"/info_produto/{cont}",
            [
                UniProduto(cont)
            ],
        )


    def route_change(route):
        page.views.clear()
        page.views.append(pages[page.route])




    
    page.add(container,info_clientes_view)

    page.on_route_change = route_change
    page.go(page.route)

app(target=main,assets_dir='assets')