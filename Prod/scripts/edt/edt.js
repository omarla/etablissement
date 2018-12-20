class EdtTableBody extends React.Component {
    constructor(props) {
        super(props);
    }

    render() {
        let max = 100;
        let objects = new Array();

        let start = 9;
        let end = 18;

        for (let i = start; i < end; i++) {
            for (let j = 0; j < 3; j++) {
                objects.push(
                    <EdtTableBodyColumn time={i + j / 5} />
                );
            }
        }

        return (
            <table className="mx-auto table-border-collapse" >
                <thead className="edt-header">
                    <th className="bg-transparent border-0"></th>
                    <th className="col-lundi text-white col-edt">Lundi</th>
                    <th className="col-mardi text-white col-edt">Mardi</th>
                    <th className="col-mercredi text-white col-edt">Mercredi</th>
                    <th className="col-jeudi text-white col-edt">Jeudi</th>
                    <th className="col-vendredi text-white col-edt">Vendredi</th>
                </thead>
                <tbody className="bg-white" >
                    {objects}
                </tbody>
            </table>
        );

    }
}


class EdtTableBodyColumn extends React.Component {
    constructor(props) {
        super(props);
    }

    render() {

        let hours = parseInt(this.props.time);
        let minuts = parseInt(Math.round((this.props.time * 100), 0) % 100);
        let isNewHour = minuts == 0;
        let classNameAdd = isNewHour ? ' newHour' : '';

        if (isNewHour)
            minuts = "00";
        if (hours < 10)
            hours = "0" + hours;


        return (
            <tr className={"body-tr" + classNameAdd}>
                <td>{hours}:{minuts}</td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
        )
    }
}

ReactDOM.render(
    <EdtTableBody />,
    document.getElementById("edt-body")
);