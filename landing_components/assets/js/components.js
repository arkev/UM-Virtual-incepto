// Define WebComponent
var proto = Object.create(HTMLElement.prototype, {
        createdCallback: {
          value: function() {
              var curso = this.getAttribute('curso');
              var debes = this.getAttribute('debes');
          }
        }
});

// Iconos
class Redes extends React.Component {
        render() {
          return <ul className="icons">
                        <li><a href="https://twitter.com/UMVirtual" className="icon alt fa-twitter"><span className="label">Twitter</span></a>
                        </li>
                        <li><a href="https://www.facebook.com/umvirtual" className="icon alt fa-facebook"><span className="label">Facebook</span></a>
                        </li>
                        <li><a href="mailto:umvirtual@um.edu.mx" className="icon alt fa-envelope"><span className="label">Email</span></a>
                        </li>
                    </ul>;
        }
}
      
// Prueba
class Prueba extends React.Component {
        render() {
            var today = new Date();
            var year = today.getFullYear();
            return <ul className="copyright">
                        <li>© <span>{year}</span> UM Virtual. Todos los derechos reservados</li>
                    </ul>;
            }
}

// Encabezado
class Encabezado extends React.Component {
        render() {
            return <div><h2>para ser <br />+<br /> productivo</h2><h3>DEBES DE SER {this.props.debes}</h3></div>;
            }
}
              
// Instrucciones
class Instrucciones extends React.Component {
    render() {
        return <p>Recibe información para inscribirte al curso online gratis "{this.props.curso}"</p>;
    }
}

// Remarketing
class Retargeting extends React.Component {
    render() {
        return <div className="hide">
            <img height="1" width="1" alt="Doble click" src="//googleads.g.doubleclick.net/pagead/viewthroughconversion/957296960/?value=0&amp;guid=ON&amp;script=0" />
            <img height="1" width="1" alt="Facebook" src="https://www.facebook.com/tr?id=954439487953611&ev=PageView&noscript=1" />
        </div>;
    }
}

// Mount React Component (which uses WebComponent which uses React)
var container = document.getElementById('foot');
ReactDOM.render(<Redes />, container);
      
var hola = document.getElementById('copyright');
ReactDOM.render(<Prueba />, hola);

var head = document.getElementById('encabezado');
ReactDOM.render(<Encabezado debes="SALUDABLE" />, head);

var instrucc = document.getElementById('instrucciones');
ReactDOM.render(<Instrucciones curso="Activación física para el bienestar personal" />, instrucc);

var remarketing = document.getElementById('retargeting');
ReactDOM.render(<Retargeting />, remarketing);