<template>
  <div>
    <h2>Articles</h2>
    <form @submit.prevent="addArticle" class="mb-3">
      <div class="form-group">
        <label>Title</label>
        <input type="text" name="title" class="form-control" v-model="article.title">
      </div>
      <div class="form-group">
        <label>Title</label>
        <textarea name="body" class="form-control" v-model="article.body"></textarea>
      </div>
      <div class="form-group">
        <input type="submit" class="btn btn-block btn-success">
      </div>
    </form>
    <nav aria-label="Page navigation example">
      <ul class="pagination">
        <li class="page-item" v-bind:class="[{disabled: !pagination.prev_page_url}]">
          <a class="page-link" href="#" @click="getArticles(pagination.prev_page_url)">Previous</a>
        </li>
        <li class="page-item disabled">
          <a class="page-link text-dark" href="#">Page {{ pagination.current_page }} of {{ pagination.last_page }}</a>
        </li>
        <li class="page-item" v-bind:class="[{disabled: !pagination.next_page_url}]">
          <a class="page-link" href="#" @click="getArticles(pagination.next_page_url)">Next</a>
        </li>
      </ul>
    </nav>
    <table class="table">
      <thead>
        <tr>
          <th>ID</th>
          <th>Title</th>
          <th>Body</th>
          <th>Created At</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="article in articles" v-bind:key="article.id">
          <td>{{ article.id }}</td>
          <td>{{ article.title }}</td>
          <td>{{ article.body }}</td>
          <td>{{ article.created_at }}</td>
          <td>
            <button class="btn btn-warning btn-sm" @click="editArticle(article)">Edit</button>
            <button class="btn btn-danger btn-sm" @click="deleteArticle(article.id)">Delete</button>
          </td>
        </tr>
      </tbody>
    </table>
  </div>
</template>

<script>
  export default {
    data() {
      return {
        articles: [],
        article: {
          id: '',
          title: '',
          body: ''
        },
        article_id: '',
        pagination: {},
        edit: false
      }
    },
    created() {
      this.getArticles();
    },
    methods: {
      getArticles: function(page_url){
        let vm = this;
        axios.get('/api/articles').then(response => {
          this.articles = response.data.data;
          vm.makePagination(response.data.meta, response.data.links)
        }).catch(error=>console.log(error))
      },
      makePagination: function(meta, links) {
        let pagination = {
          current_page: meta.current_page,
          last_page: meta.last_page,
          next_page_url: links.next,
          prev_page_url: links.prev,
        }

        this.pagination = pagination;
      },
      deleteArticle: function(article_id) {
        if (confirm('Are you sure?')) {
          fetch(`api/articles/${article_id}`,{
            method: 'delete',
          }).then(response => response.json()).then(data => {
            alert('Article deleted!');
            this.getArticles();
          }).catch(err=>console.log(err))
        }
      },
      addArticle: function() {
        if (this.edit === false) {
          // Add
          fetch('api/articles', {
            method: 'post',
            body: JSON.stringify(this.article),
            headers: {
              'content-type': 'application/json'
            }
          }).then(response => response.json()).then(data => {
            this.article.title = '';
            this.article.body = '';
            alert('Article added!');
            this.getArticles();
          }).catch(err => console.log(err))
        } else {
          // Update
          fetch(`api/articles/${this.article.id}`, {
            method: 'put',
            body: JSON.stringify(this.article),
            headers: {
              'content-type': 'application/json'
            }
          }).then(response => response.json()).then(data => {
            this.article.title = '';
            this.article.body = '';
            this.edit = false;
            alert('Article updated!');
            this.getArticles();
          }).catch(err => console.log(err))
        }
      },
      editArticle: function(article) {
        this.article.id = article.id;
        this.article.article_id = article.id;
        this.article.title = article.title;
        this.article.body = article.body;
        this.edit = true;
      }
    }
  }
</script>
