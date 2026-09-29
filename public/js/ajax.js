async function atualizarDados() {
    const status = document.getElementById('ajaxStatus');
    try {
        const response = await fetch('ajax/dados.php', { headers: { Accept: 'application/json' } });
        if (!response.ok) throw new Error('Falha na consulta.');
        const data = await response.json();
        if (!data.ok) throw new Error(data.message || 'Falha na API.');

        preencherLista('usuarios', data.usuarios, item => `${item.id} - ${item.nome} (${item.email})`);
        preencherLista('fornecedores', data.fornecedores, item => `${item.id} - ${item.nome} (${item.email || 'sem e-mail'})`);
        preencherLista('produtos', data.produtos, item => `${item.id} - ${item.nome} - R$ ${Number(item.preco).toFixed(2)} (${item.fornecedor})`);
        status.className = 'alert alert-success';
        status.textContent = `Atualizado em ${new Date().toLocaleTimeString('pt-BR')}`;
    } catch (error) {
        status.className = 'alert alert-danger';
        status.textContent = error.message;
    }
}

function preencherLista(id, itens, formatar) {
    const container = document.getElementById(id);
    container.replaceChildren();
    if (!itens.length) {
        const vazio = document.createElement('p');
        vazio.className = 'text-muted small';
        vazio.textContent = 'Nenhum registro.';
        container.appendChild(vazio);
        return;
    }
    itens.forEach(item => {
        const linha = document.createElement('p');
        linha.className = 'small border-bottom pb-2';
        linha.textContent = formatar(item);
        container.appendChild(linha);
    });
}

atualizarDados();
setInterval(atualizarDados, 3000);
